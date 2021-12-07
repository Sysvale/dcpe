// user roles
export const SUDO = 'sudo';
export const PATIENT = 'patient';
export const PROFESSIONAL = 'professional';

export const ALL = [
    SUDO,
    PATIENT,
    PROFESSIONAL,
];

export const HIERARCHY_LEVELS = {
    [SUDO]: 0,
    [PATIENT]: -1,
    [PROFESSIONAL]: -2,
};

export const ROLES_NAMES = {
    [SUDO]: 'Sudo',
    [PATIENT]: 'Paciente',
    [PROFESSIONAL]: 'Profissional da Saúde',
};

export const rolesNames = function getRolesNames(userRole){
    return ROLES_NAMES[userRole];
};

export const highestHierarchyRole = function getHighestHierarchyRoles(user){
    return user.roles.reduce((accRole, currRole) => (
		HIERARCHY_LEVELS[currRole] >= HIERARCHY_LEVELS[accRole] ? currRole : accRole
	), PROFESSIONAL);
};

export const sameOrLowerRoles = function getSameOrLowerRoles(user) {
	const highestRole = highestHierarchyRole(user);
	return ALL.filter(role => HIERARCHY_LEVELS[role] < HIERARCHY_LEVELS[highestRole]);
};

export const canEditRoles = [
	SUDO,
	PROFESSIONAL,
];
