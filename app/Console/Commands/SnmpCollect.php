<?php

namespace App\Console\Commands;

use App\Ams\SNMP\Entity\SnmpInterface;
use App\Ams\SNMP\Entity\SnmpLoadAvg;
use App\Ams\SNMP\Entity\SnmpMemory;
use App\Ams\SNMP\SNMPClient;
use App\Models\Config;
use App\Models\Devices;
use App\Models\Monitor;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use InfluxDB\Client;
use InfluxDB\Database;
use InfluxDB\Database\Exception;
use InfluxDB\Point;
use JetBrains\PhpStorm\NoReturn;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionFunction;
use ReflectionObject;
use SNMP;
use Throwable;


class SnmpCollect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:snmp-collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * @return void
     */
     public function handle(): void
    {


        Cache::flush();

            $this->line('check influxdb database is ready');
            $this->checkInflux();
            $this->line('runtime cache clear');

            while (true) {
                $devices = Devices::all();
                foreach ($devices as $device) {
                    $masterMonitor = $device->getMasterMonitor();
                    $monitors = Monitor::where('device_id', $device->id)->where('type', 'SNMP')->get();
                    foreach ($monitors as $monitor) {

                        $points = [];
                        // FUTUR FEATURE -  NOW NOT WORK
                        //$this->task(function () use ($monitor, $device, $masterMonitor) {
                        //    $points = [];
                        //    $client = Client::fromDSN('influxdb://' . env('INFLUX_USERNAME') . '@' . env('INFLUX_HOST') . ':' . 8086 . '/' . env('INFLUX_DB'), 5);
//
                        //    $session = new SNMPClient(SNMP::VERSION_1, $masterMonitor->host, $monitor->community);
//
                        //    $points = array_merge($points, SnmpCollect::forInterfaces($session->interfaces(), $monitor, $device, $masterMonitor));
                        //    $client->writePoints($points, Database::PRECISION_SECONDS);
                        //}, 'collect iface for ' . $device->name, $monitor->id);

                        $this->task(function () use ($monitor, $device, $masterMonitor) {
                            $points = [];
                            $client = Client::fromDSN('influxdb://' . env('INFLUX_USERNAME') . '@' . env('INFLUX_HOST') . ':' . 8086 . '/' . env('INFLUX_DB'), 5);
                            $session = new SNMPClient(SNMP::VERSION_1, $masterMonitor->host, $monitor->community);
                            $points = array_merge($points, SnmpCollect::forCpu($session->cpus(), $monitor, $device, $masterMonitor));
                            $client->writePoints($points, Database::PRECISION_SECONDS);
                        }, 'collect cpu for ' . $device->name, $monitor->id);
                        $this->task(function () use ($monitor, $device, $masterMonitor) {
                            $points = [];
                            $client = Client::fromDSN('influxdb://' . env('INFLUX_USERNAME') . '@' . env('INFLUX_HOST') . ':' . 8086 . '/' . env('INFLUX_DB'), 5);
                            $session = new SNMPClient(SNMP::VERSION_1, $masterMonitor->host, $monitor->community);
                            $points = array_merge($points, SnmpCollect::forMemory($session->memory(), $monitor, $device, $masterMonitor));
                            $client->writePoints($points, Database::PRECISION_SECONDS);
                        }, 'collect memory for ' . $device->name, $monitor->id);
                        $this->task(function () use ($monitor, $device, $masterMonitor) {
                            $points = [];
                            $client = Client::fromDSN('influxdb://' . env('INFLUX_USERNAME') . '@' . env('INFLUX_HOST') . ':' . 8086 . '/' . env('INFLUX_DB'), 5);
                            $session = new SNMPClient(SNMP::VERSION_1, $masterMonitor->host, $monitor->community);
                            $points = array_merge($points, SnmpCollect::forLoadAvg($session->loadAvg(), $monitor, $device, $masterMonitor));
                            $client->writePoints($points, Database::PRECISION_SECONDS);
                        }, 'collect load for ' . $device->name, $monitor->id);


                    }
                }
                sleep(30);
            }

    }

    /**
     * @param Closure $c
     * @return string
     * @throws \ReflectionException
     */
    function closureDump(Closure $c): string
    {
        $str = 'function (';
        $r = new ReflectionFunction($c);
        $params = array();
        foreach ($r->getParameters() as $p) {
            $s = '';
            if ($p->isArray()) {
                $s .= 'array ';
            } else if ($p->getClass()) {
                $s .= $p->getClass()->name . ' ';
            }
            if ($p->isPassedByReference()) {
                $s .= '&';
            }
            $s .= '$' . $p->name;
            if ($p->isOptional()) {
                $s .= ' = ' . var_export($p->getDefaultValue(), TRUE);
            }
            $params [] = $s;
        }
        $str .= implode(', ', $params);
        $str .= '){' . PHP_EOL;
        $lines = file($r->getFileName());
        for ($l = $r->getStartLine(); $l < $r->getEndLine(); $l++) {
            $str .= $lines[$l];
        }
        return $str;
    }


    /**
     * @param Closure $closure
     * @param string $name
     * @return void
     * @throws \ReflectionException
     */
    public function task(Closure $closure, string $name, string $mutex): void
    {
        $sing = sha1($this->closureDump($closure).$name.$mutex);
        $lockKey = 'lock-task-' . $sing;

        $lockDuration = 300;

        $alreadyLocked = !Cache::add($lockKey, true, $lockDuration);

        if (!$alreadyLocked) {
            $this->line("launching task '" . $name . "'");
            dispatch(function () use ($closure, $sing, $lockKey) {
                try {
                    Cache::add($lockKey, true, 999999);
                    $t1 = microtime(true);
                    $closure();
                    Cache::set('task-time-' . $sing, microtime(true) - $t1);
                } catch (Throwable $e) {
                    dump($e);
                    \Sentry\captureException($e);
                }
                finally {
                    Cache::forget($lockKey); // Libérer le verrou en supprimant la clé

                }
            });
        } else {
            $this->line("Task '" . $name . "' is already running");
        }
    }

    /**
     * @return void
     * @throws Client\Exception
     * @throws Exception
     * @throws \InfluxDB\Exception
     */
    private function checkInflux(): void
    {
        $client = Client::fromDSN('influxdb://' . env('INFLUX_USERNAME') . '@' . env('INFLUX_HOST') . ':' . 8086 , 5);
        $databaseList = $client->listDatabases();
        if (in_array(env('INFLUX_DB'), $databaseList)) { //IF DB EXIST
            // $client->selectDB($configDB['INFLUXDB_DATABASE'])->drop();
            //$this->line('influx database removed');
            //dd(1);
            return;
        } else {
            $database = $client->selectDB(env('INFLUX_DB'));
            $database->create();
            $this->line('influx database created');
        }
    }

    /**
     * @param SnmpLoadAvg $smtpLoadAvg
     * @param Monitor $m
     * @param Devices $d
     * @return array
     * @throws Exception
     */
    public static function forLoadAvg(SnmpLoadAvg $smtpLoadAvg, Monitor $m, Devices $d): array
    {
        $points = [];

        Cache::set('m' . $m->id . '-loadavg_1m', floatval($smtpLoadAvg->load1m));
        $points[] = new Point(
            'loadavg_1m',
            floatval($smtpLoadAvg->load1m),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );
        Cache::set('m' . $m->id . '-loadavg_5m', floatval($smtpLoadAvg->load5m));
        $points[] = new Point(
            'loadavg_5m',
            floatval($smtpLoadAvg->load5m),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );
        Cache::set('m' . $m->id . '-loadavg_15m', floatval($smtpLoadAvg->load15m));
        $points[] = new Point(
            'loadavg_15m',
            floatval($smtpLoadAvg->load15m),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );

        return $points;
    }

    /**
     * @param SnmpMemory $snmpMemory
     * @param Monitor $m
     * @param Devices $d
     * @return array
     * @throws Exception
     */
    public static function forMemory(SnmpMemory $snmpMemory, Monitor $m, Devices $d): array
    {
        $points = [];


        Cache::set('m' . $m->id . '-memory_used', intval($snmpMemory->used * 1024));
        $points[] = new Point(
            'memory_used',
            intval($snmpMemory->used * 1024),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );
        Cache::set('m' . $m->id . '-memory_free', intval($snmpMemory->free * 1024));
        $points[] = new Point(
            'memory_free',
            intval($snmpMemory->free * 1024),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );
        Cache::set('m' . $m->id . '-memory_total', $snmpMemory->total * 1024);
        $points[] = new Point(
            'memory_total',
            intval($snmpMemory->total * 1024),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );

        return $points;
    }


    /**
     * @param array $snmpCPUs
     * @param Monitor $m
     * @param Devices $d
     * @return array
     * @throws Exception
     */
    public static function forCpu(array $snmpCPUs, Monitor $m, Devices $d): array
    {
        $points = [];
        foreach ($snmpCPUs as $key => $snmpCPU) {
            $points[] = new Point(
                'core',
                intval($snmpCPU),
                ['cpuid' => $key, 'monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
                [],
                time()
            );
        }

        $allCPU = array_sum($snmpCPUs);
        $avg = $allCPU / count($snmpCPUs);
        Cache::set('m' . $m->id . '-avg_cpu', intval($avg));
        $points[] = new Point(
            'avg_cpu',
            floatval(round($avg, 2)),
            ['monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
            [],
            time()
        );

        return $points;


    }

    /**
     * @param SnmpInterface[] $snmpInterfaces
     * @return Point[]
     * @throws Exception
     */
    public static function forInterfaces(array $snmpInterfaces, Monitor $m, Devices $d): array
    {
        $points = [];

        foreach ($snmpInterfaces as $interface) {

            $nomsDeProprietes = [
                "ifMtu",
                "ifSpeed",
                "ifInOctets",
                "ifInUcastPkts",
                "ifInNUcastPkts",
                "ifInDiscards",
                "ifInErrors",
                "ifInUnknownProtos",
                "ifOutOctets",
                "ifOutUcastPkts",
                "ifOutNUcastPkts",
                "ifOutDiscards",
                "ifOutErrors",
                'ifOutOctetsRate',
                'ifInOctetsRate',
                'ifName',
                'ifConnectorPresent'

            ];

            $reflexion = new ReflectionObject($interface);

            foreach ($reflexion->getProperties() as $propriete) {
                $nomPropriete = $propriete->getName();

                // Vérifie si le nom de la propriété est présent dans le tableau
                if (in_array($nomPropriete, $nomsDeProprietes)) {
                    $valeurPropriete = $propriete->getValue($interface);
                    $points[] = new Point(
                        $nomPropriete,
                        floatval($valeurPropriete),
                        ['identifier' => $interface->ifIndex . ' - ' . $interface->ifDescr, 'ifDescr' => $interface->ifDescr, 'ifPhysAddress' => $interface->ifPhysAddress, 'ifIndex' => $interface->ifIndex, 'monitor_id' => $m->id, 'device_id' => $d->id, 'device_name' => $d->name],
                        [],
                        time()
                    );
                }
            }


        }
        return $points;

    }


}
