import {
    ProntuaryEdit,
    ProntuaryContinue,
    ProntuaryMainPage,
    ProfessionalView,
} from './pages';

import * as roles from '../../core/constants/userRoles';

export const PRONT_STEP = 'prontuary.step';
export const PRONT_EDIT = 'prontuary.edit';
export const PRONT_VIEW = 'prontuary.view';

const MODULE_NAME = 'prontuary';

export default [
    {
        name: PRONT_EDIT,
        path: '/prontuary/edit/:id',
        component: ProntuaryEdit,
        meta: {
            alias: 'Alterar Prontuário',
            roles: [roles.PATIENT],
            tags: [MODULE_NAME],
        },
    },
    {
        name: PRONT_STEP,
        path: '/prontuary/continue/:step',
        component: ProntuaryContinue,
        meta: {
            alias: 'Continuar Prontuário',
            roles: [roles.PATIENT],
            tags: [MODULE_NAME],
        },
    },
    

];