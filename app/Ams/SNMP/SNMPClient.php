<?php

namespace App\Ams\SNMP;


use App\Ams\SNMP\Entity\SnmpInterface;
use App\Ams\SNMP\Entity\SnmpLoadAvg;
use App\Ams\SNMP\Entity\SnmpMemory;
use InvalidArgumentException;
use SNMP;

class SNMPClient extends SNMP
{


    private function magicParse($key, $val): array
    {
        // Séparation de la chaîne $key en deux parties sur '::'
        $parts = explode('::', $key);
        if (count($parts) != 2) {
            throw new InvalidArgumentException("Clé SNMP invalide: '$key'");
        }
        [$mib, $right] = $parts;

        // Séparation de $right en nom et index s'il contient '.'
        $nameIndex = explode('.', $right . '.'); // Ajout d'un '.' pour garantir un tableau de 2 éléments
        $name = $nameIndex[0];
        $index = $nameIndex[1] !== '' ? $nameIndex[1] : null;

        // Séparation de la valeur en type et valeur
        $typeValue = explode(': ', $val, 2);
        if (count($typeValue) != 2) {
            throw new InvalidArgumentException("Valeur SNMP invalide: '$val'");
        }
        [$type, $value] = $typeValue;

        // Nettoyage de la valeur
        $value = str_replace(' kB', '', $value);

        return [$mib, $name, $index, $type, trim($value)];
    }


    /**
     * @return SnmpInterface[]
     */
    public function interfaces(): array
    {


        $entry = [];
        $timings = [];
        $lasttake = null;
        while (count($entry) < 6) {

            $timings[count($entry)] = microtime(true);
            $timing = microtime(true);
            $lasttake = $this->walk("1.3.6.1.2.1.2.2.1");
            $entry[] = $lasttake;
            $timings[count($entry) - 1] = microtime(true) - $timings[count($entry) - 1];
        }
        $avgTime = array_sum($timings) / count($timings);
        $speedsIn = $this->getInterfacesSpeed($entry, 'in');
        $speedsOut = $this->getInterfacesSpeed($entry, 'out');

        $data = [];

        $fulltree = array_merge($this->walk("1.3.6.1.2.1.31.1.1.1"), $lasttake);
        foreach ($fulltree as $key => $branch) {

            list($mib, $name, $index, $type, $value) = $this->magicParse($key, $branch);

            if (!empty($value)) {

                if (str_contains($value, '(')) {


                    $value = explode('(', $value);

                    $value = str_replace(')', '', $value[1]);
                }
            }

            if (isset($data[$index])) {
                $data[$index]->$name = $value;
            } else {
                $data[$index] = new SnmpInterface();
                $data[$index]->$name = $value;
            }
        }

        foreach ($data as $d) {
            if (isset($speedsOut[$d->ifIndex]) && isset($speedsIn[$d->ifIndex])) {
                $d->ifOutOctetsRate = $speedsOut[$d->ifIndex] / $avgTime * 1.4;
                $d->ifInOctetsRate = $speedsIn[$d->ifIndex] / $avgTime * 1.4;
            } else {
                $d->ifOutOctetsRate = 0;
                $d->ifInOctetsRate = 0;
            }
        }

        return $data;
    }

    private function getInterfacesSpeed($entry, $inout = 'in')
    {
        $mesure = [];
        $results = [];
        $oid = ($inout == 'in') ? "IF-MIB::ifInOctets" : "IF-MIB::ifOutOctets";

        foreach ($entry as $fulltree) {
            foreach ($fulltree as $key => $branch) {
                if (str_contains($key, $oid)) {
                    list($mib, $name, $index, $type, $cval) = $this->magicParse($key, $branch);

                    if (!isset($val[$index])) {
                        $val[$index] = $cval;
                    }
                    if ($val[$index] != $cval) {
                        $speed = $cval - $val[$index];

                        if ($speed <= 0) {
                            $a2 = 4294967295 - $val[$index];
                            $n = $a2 + $cval;
                            $speed = $n;
                        }

                        if (!isset($mesure[$index])) {
                            $mesure[$index] = [];
                        }
                        if (count($mesure[$index]) < count($entry) - 2) {
                            $mesure[$index][] = $speed;
                        } else {
                            $a = array_filter($mesure[$index]);
                            sort($mesure[$index]);
                            if (count($mesure[$index]) >= 2) {
                                $mesure[$index] = array_slice($mesure[$index], 1, count($mesure[$index]) - 2);
                            }
                            $average = array_sum($a) / count($a);
                            $results[$index] = $average;
                        }

                        $val[$index] = $cval;
                    }
                }
            }
        }

        return $results;
    }

    public function cpus()
    {
        $icore = 0;
        $cpus = [];
        $fulltree = $this->walk("1.3.6.1.2.1.25.3.3.1.2");
        foreach ($fulltree as $key => $branch) {
            list($mib, $name, $index, $type, $value) = $this->magicParse($key, $branch);
            $cpus[$icore] = $value;
            $icore++;
        }
        return $cpus;
    }

    public function loadAvg(): SnmpLoadAvg
    {
        $fulltree = $this->walk("1.3.6.1.4.1.2021.10.1.3");
        $i = 0;
        $loadavg = new SnmpLoadAvg();
        foreach ($fulltree as $key => $branch) {
            list($mib, $name, $index, $type, $value) = $this->magicParse($key, $branch);

            if ($i === 0) {
                $loadavg->load1m = $value;
            }
            if ($i === 1) {
                $loadavg->load5m = $value;
            }
            if ($i === 2) {
                $loadavg->load15m = $value;
            }
            $i++;
        }


        return $loadavg;
    }

    public function memory()
    {


        $fullMemory = $this->walk("1.3.6.1.4.1.2021.4.5.0");
        list($mib, $name, $index, $type, $value) = $this->magicParse("UCD-SNMP-MIB::memTotalReal.0", $fullMemory["UCD-SNMP-MIB::memTotalReal.0"]);
        $total = $value;

        $realAvl = $this->walk("1.3.6.1.4.1.2021.4.6.0");
        list($mib, $name, $index, $type, $value) = $this->magicParse("UCD-SNMP-MIB::memAvailReal.0", $realAvl["UCD-SNMP-MIB::memAvailReal.0"]);
        $realAlv = $value;

        $cached = $this->walk("1.3.6.1.4.1.2021.4.15.0");
        list($mib, $name, $index, $type, $value) = $this->magicParse("UCD-SNMP-MIB::memCached.0", $cached["UCD-SNMP-MIB::memCached.0"]);
        $cachedMem = $value;

        $free = $realAlv + $cachedMem;

        $memory = new SnmpMemory();
        $memory->free = $free;
        $memory->used = ($total - $free);
        $memory->total = $total;

        return $memory;

    }

    public function uptime()
    {
        $fulltree = $this->walk("1.3.6.1.2.1.1.3.0");
        list($mib, $name, $index, $type, $value) = $this->magicParse("DISMAN-EVENT-MIB::sysUpTimeInstance", $fulltree["DISMAN-EVENT-MIB::sysUpTimeInstance"]);
        $exploder = explode(')', $value);
        $value = str_replace('(', '', $exploder[0]);
        return round(floatval($value) / 100, 0);
    }

}
