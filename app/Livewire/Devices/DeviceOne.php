<?php

namespace App\Livewire\Devices;

use App\Ams\GraphUtils;
use App\Models\Alert;
use App\Models\Devices;
use App\Models\Monitor;
use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Illuminate\View\View;
use InfluxDB\Client;
use Livewire\Component;

class DeviceOne extends Component
{
    public ?int $id;
    public ?\App\Models\Monitor $monitor;

    public ?string $username = "";
    public ?string $password = "";
    public ?string $community = "";
    public ?string $host = "";

    public ?int $timeout = 2;
    public ?int $interval = 1;
    public ?int $retry = 3;

    public ?Devices $device;
    public ?int $iface = null;
    public string $selected_panel = "Monitor";

    public ?string $health;

    public string $timerange = 'H';
    public int $sampling = 100;
    public string $name;


    /**
     * @return bool
     */
    public function hasSNMP(): bool
    {
        return \App\Models\Monitor::query()->where('device_id', $this->device->id)->where('type', 'SNMP')->exists();
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function mount(int $id): void
    {
        $this->id = $id;
        $this->device = \App\Models\Devices::where('id', $this->id)->first();
        $this->monitor = $this->device->getMasterMonitor();
        $this->name = $this->monitor->name;
        $this->host = $this->monitor->host;
        $this->timeout = $this->monitor->timeout;
        $this->interval = $this->monitor->interval;
        $this->retry = $this->monitor->retry;
        $snmp = \App\Models\Monitor::query()->where('device_id', $this->device->id)->where('type', 'SNMP')->first();
        if ($snmp) {

            $this->community = $snmp->community;
            $this->username = $snmp->username;
            $this->password = $snmp->password;
        }
        if ($this->hasSNMP()) {
            $this->showHealth('avg_cpu');
        }
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $this->device = \App\Models\Devices::where('id', $this->id)->first();
        $this->monitor = $this->device->getMasterMonitor();
        if ($this->selected_panel === "Latency") {
            $this->dispatch('updateGraph', ['target' => 'latency', 'data' => $this->getInfluxDataGraph('latency', 200, "ICMP")]);
        }
        if ($this->selected_panel === "Health") {
            $this->dispatch('updateGraph', ['target' => $this->health . 'Graph', 'data' => $this->getInfluxDataGraph($this->health)]);
        }
        return view('livewire.devices.device-one')->layout('layout-large');
    }


    /**
     * Permet la selection du graph dans l'onglet santé
     * @param string $section
     * @return void
     * @throws Exception
     */
    public function showHealth(string $section): void
    {

        $this->health = $section;
        $this->dispatch('updateGraph', ['target' => $section . 'Graph', 'data' => $this->getInfluxDataGraph($section)]);
    }

    /**
     * @param string $type
     * @return void
     * @throws Exception
     */
    public function setGraphRange(string $type): void
    {

        $this->timerange = $type;
        if ($this->timerange == 'H') {
            $this->sampling = 100;
        }
        if ($this->timerange == 'D') {
            $this->sampling = 300;
        }
        if ($this->timerange == 'M') {
            $this->sampling = 1000;
        }
        if ($this->timerange == 'Y') {
            $this->sampling = 3000;
        }

        if ($this->selected_panel === 'Iface') {
            if ($this->iface) {
                $this->bindIface(intval($this->iface));
            }

        }

        if ($this->selected_panel === 'Health') {
            $this->showHealth($this->health);
        }
    }

    /**
     * Perrmet la selection dans le pane
     * @param string $string
     * @return void
     * @throws Exception
     */
    public function selectPanel(string $string): void
    {
        $this->selected_panel = $string;
        if ($this->selected_panel === "Health") {
            $this->showHealth('avg_cpu');
        }

        if ($this->selected_panel === "Latency") {
            $this->dispatch('updateGraph', ['target' => 'latency', 'data' => $this->getInfluxDataGraph('latency', 200, "ICMP")]);
        }

    }

    /**
     * Retourne la valeur de la derneir mesure mesurement valeur
     * @param string $mesurment
     * @return mixed
     */
    public function getLast(string $mesurment): mixed
    {
        if ($this->hasSNMP()) {
            $monitor = \App\Models\Monitor::query()->where('device_id', $this->id)->where('type', 'SNMP')->first();
            return \Cache::get('m' . $monitor->id . '-' . $mesurment);
        }
        return 0;

    }


    /**
     * @param string $dataname
     * @param int $points
     * @param string $type
     * @return array
     * @throws Exception
     */
    private function getInfluxDataGraph(string $dataname, int $points = 200, string $type = 'SNMP'): array
    {

        $end = Carbon::now();
        $start = $end->clone()->subHour();


        if ($this->timerange == "D") {
            $end = Carbon::now();
            $start = $end->clone()->subDay();

        }

        if ($this->timerange == "M") {
            $end = Carbon::now();
            $start = $end->clone()->subMonth();

        }

        if ($this->timerange == "Y") {
            $end = Carbon::now();
            $start = $end->clone()->subYear();

        }

        $monitor = \App\Models\Monitor::query()->where('device_id', $this->id)->where('type', $type)->first();
        if ($type === "SNMP") {
            $query = "SELECT * FROM \"" . $dataname . "\" WHERE (\"monitor_id\"::tag = '" . $monitor->id . "') AND time >= '" . $start->format(DateTimeInterface::RFC3339) . "' AND time <= '" . $end->format(DateTimeInterface::RFC3339) . "' ORDER BY time";

        } else {
            $query = "SELECT * FROM \"" . $dataname . "\" WHERE (\"device_id\"::tag = '" . $this->id . "') AND time >= '" . $start->format(DateTimeInterface::RFC3339) . "' AND time <= '" . $end->format(DateTimeInterface::RFC3339) . "' ORDER BY time";

        }


        $client = new Client(
            env('INFLUX_HOST'),
            8086,
            env('INFLUX_USERNAME')
        );


        $database = $client->selectDB(env('INFLUX_DB'));
        $result = $database->query($query);


        $result_chart = [];
        foreach ($result->getPoints() as $p) {
            $result_chart[] = [Carbon::parse($p['time'])->timestamp * 1000, round($p['value'], 2)];
        }

        return GraphUtils::resamplePoints($result_chart, $this->sampling);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function ifeceList(): array
    {
        $query = "SHOW TAG VALUES ON " . env('INFLUX_DB') . " FROM \"ifInOctets\" WITH KEY = \"identifier\"";


        $client = new Client(
            env('INFLUX_HOST'),
            8086,
            env('INFLUX_USERNAME')
        );


        $database = $client->selectDB(env('INFLUX_DB'));
        $result = $database->query($query);
        $json = json_decode($result->getRaw(), true);
        $results = [];

        if (isset($json['results'][0]['series'])) {
            foreach ($json['results'][0]['series'][0]['values'] as $ifacesResult) {
                list($key, $val) = explode(' - ', $ifacesResult[1]);
                $results[$key] = $val;
            }
        }

        return $results;
    }

    /**
     * @param string $iface
     * @return void
     * @throws Exception
     */
    public function selectIface(string $iface): void
    {
        $this->iface = intval($iface);
        $this->bindIface(intval($iface));
    }

    /**
     * @param int $if
     * @return void
     * @throws Exception
     */
    public function bindIface(int $if): void
    {
        $client = new Client(
            env('INFLUX_HOST'),
            8086,
            env('INFLUX_USERNAME')
        );


        $database = $client->selectDB(env('INFLUX_DB'));

        $result = $database->query("SELECT * FROM \"ifInOctetsRate\" WHERE (\"ifIndex\"::tag = '" . intval($if) . "' AND \"device_id\"::tag = '" . $this->device->id . "') ORDER BY time");

        $result_chart_in = [];
        foreach ($result->getPoints() as $p) {
            $result_chart_in[] = [Carbon::parse($p['time'])->timestamp * 1000, round(($p['value']), 2)];
        }

        $result = $database->query("SELECT * FROM \"ifOutOctetsRate\" WHERE (\"device_id\"::tag = '" . $this->device->id . "' AND \"ifIndex\"::tag = '" . intval($if) . "') Order by time");

        $result_chart_out = [];
        foreach ($result->getPoints() as $p) {
            $result_chart_out[] = [Carbon::parse($p['time'])->timestamp * 1000, round(($p['value']), 2)];
        }
        $result_chart_in = GraphUtils::resamplePoints($result_chart_in, $this->sampling);
        $result_chart_in = GraphUtils::multiply($result_chart_in, 8);
        $result_chart_in = GraphUtils::order($result_chart_in);

        $result_chart_out = GraphUtils::resamplePoints($result_chart_out, $this->sampling);
        $result_chart_out = GraphUtils::negative($result_chart_out);
        $result_chart_out = GraphUtils::multiply($result_chart_out, 8);

        $result_chart_out = GraphUtils::order($result_chart_out);


        $this->dispatch('updateDoubleGraph', ['target' => 'ifaceGraph', 'data' => [$result_chart_in, $result_chart_out]]);
    }

    public function editMasterMonitor()
    {
        $this->monitor->name = $this->name;
        $this->monitor->host = $this->host;
        $this->monitor->timeout = $this->timeout;
        $this->monitor->retry = $this->retry;
        $this->monitor->interval = $this->interval;
        $this->monitor->save();
    }

    public function editCreateSnmp()
    {
        $monitor = \App\Models\Monitor::query()->where('device_id', $this->device->id)->where('type', 'SNMP')->first();

        if (!$monitor) {
            $monitor = new \App\Models\Monitor();
            $monitor->device_id = $this->device->id;

        } else {
            if (empty($monitor->community)) {
                $monitor->delete();
            }
        }
        if (!empty($this->community)) {

            $monitor->name = "DEFAULT SNMP";
            $monitor->host = "";
            $monitor->type = 'SNMP';
            $monitor->username = $this->username;
            $monitor->password = $this->password;
            $monitor->community = $this->community;
            $monitor->timeout = 0;
            $monitor->retry = 0;
            $monitor->interval = 0;
            $monitor->save();
        } else {

        }

    }

    function deleteDevice()
    {
        Devices::query()->where('id', $this->device->id)->delete();
        $monitors = Monitor::query()->where('device_id', $this->device->id)->get();
        foreach ($monitors as $monitor) {
            Alert::query()->where('monitor_id', $monitor->id)->delete();
            $monitor->delete();
        }

        $device_id = $this->device->id;

        $client = new Client(
            env('INFLUX_HOST'),
            8086,
            env('INFLUX_USERNAME')
        );


        $database = $client->selectDB(env('INFLUX_DB'));
// Récupérer la liste de tous les measurements
        $measurements = $database->query("SHOW MEASUREMENTS");

        foreach ($measurements->getPoints() as $measurement) {
            $measurement_name = $measurement['name'];
            $query = "DELETE FROM \"$measurement_name\" WHERE \"device_id\" = '$device_id'";
            $result = $database->query($query);

            if ($result) {
                echo "Entries deleted successfully from $measurement_name.\n";
            } else {
                echo "Failed to delete entries from $measurement_name.\n";
            }
        }
    }

}
