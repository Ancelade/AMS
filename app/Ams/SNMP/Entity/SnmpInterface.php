<?php

namespace App\Ams\SNMP\Entity;

class SnmpInterface
{
    public $ifIndex;
    public $ifDescr;
    public $ifType;
    public $ifMtu;
    public $ifSpeed;
    public $ifPhysAddress;
    public $ifAdminStatus;
    public $ifOperStatus;
    public $ifLastChange;
    public $ifInOctets;
    public $ifInUcastPkts;
    public $ifInNUcastPkts;
    public $ifInDiscards;
    public $ifInErrors;
    public $ifInUnknownProtos;
    public $ifOutOctets;
    public $ifOutUcastPkts;
    public $ifOutNUcastPkts;
    public $ifOutDiscards;
    public $ifOutErrors;
    public $ifOutQLen;
    public $ifSpecific;
    public $ifOutOctetsRate;
    public $ifInOctetsRate;

}
