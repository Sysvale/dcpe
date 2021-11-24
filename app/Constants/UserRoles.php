<?php
/*
    1. SUDO = possui todas permissões 
    2. PATIENT = usuário padrão
    3. PROFESSIONAL = profissionais da área

    regra: qualquer pessoa ao ser cadastrada no sistema, por default 
    terá nível de acesso PATIENT, e, apenas o SUDO poderá alterar o nível de acesso
    de PATIENT -> PROFESSIONAL

*/

namespace App\Constants;

class UserRoles {
    const SUDO = 'sudo';
    const PATIENT = 'patient';
    const PROFESSIONAL = 'professional';
    
    const ALL = [
        self::SUDO,
        self::PATIENT,
        self::PROFESSIONAL,
    ];
    
    const HIERARCHY_LEVELS = [
        self::SUDO => 0,
        self::PATIENT => -1,
        self::PROFESSIONAL => -2,
    ];
    
    const ROLES_NAMES = [
        self::SUDO => 'Sudo',
        self::PATIENT => 'Usuário Paciente',
        self::PROFESSIONAL => 'Usuário Profissional',
    ];
}