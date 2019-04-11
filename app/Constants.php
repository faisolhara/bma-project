<?php 

namespace App;

class Constants
{
    const ADMIN         = 'ADMIN';
    const TEKNISI       = 'TEKNISI';
    const SPV_TEKNISI   = 'SPV_TEKNISI';
    const MANAGER       = 'MANAGER';
    
    const TENANT        = 'TENANT';
    const LANDLORD      = 'LANDLORD';

    const KTP           = 'KTP';
    const SIM           = 'SIM';

    const OPEN          = 'OPEN';
    const DONE          = 'DONE';
    const CANCEL        = 'CANCEL';
    const INSPECTING    = 'INSPECTING';
    const COSTING       = 'COSTING';
    const APPROVED      = 'APPROVED';
    const PROGRESS      = 'PROGRESS';
    const WAITING_APPROVAL = 'WAITING APPROVAL';

    const ID            = 'ID';
    const EN            = 'EN';

    public static function userTypes(){
        return [
            Constants::ADMIN,
            Constants::TEKNISI,
            Constants::SPV_TEKNISI,
            Constants::MANAGER,
        ];
    }

    public static function tenantTypes(){
        return [
            Constants::TENANT,
            Constants::LANDLORD,
        ];
    }

    public static function identityCards(){
        return [
            Constants::KTP,
            Constants::SIM,
        ];
    }

    public static function complaintStatus(){
        return [
            Constants::OPEN,
            Constants::CANCEL,
            Constants::DONE,
        ];
    }

    public static function language(){
        return [
            'Indonesia' => Constants::ID,
            'English'   => Constants::EN,
        ];
    }
}