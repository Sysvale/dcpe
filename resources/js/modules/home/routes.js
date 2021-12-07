import {
    HomePage,
    HomeWelcome,
    FormStep,
} from './pages';

import * as roles from '../../core/constants/userRoles';

export const HOME_REG_STEP = 'home.registration.step';
export const HOME_WELCOME   = 'home.welcome';

const MODULE_NAME = 'home';
const SUBMODULE_NAME = 'registration';

export default [
    {
        name: HOME_REG_STEP,
        path: '/registration/:step',
        component: FormStep,
        meta: {
            alias: 'Concluir Registro',
            roles: [roles.PATIENT],
            tags: [MODULE_NAME, SUBMODULE_NAME],
        },
    },
    {
        name: HOME_WELCOME,
        path: '/home',
        component: HomeWelcome,
        meta: {
            alias: 'Bem Vindo',
            roles: [roles.PATIENT],
            tags: [MODULE_NAME],
        },
    },
];