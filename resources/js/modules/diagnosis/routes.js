
import {
    DiagnosisInit,
    DiagnosisSteps,    
} from './pages';

import * as roles from '../../core/constants/userRoles';

export const DIAGNOSIS_INIT = 'diagnosis.init';
export const DIAGNOSIS_STEP = 'diagnosis.step';

const MODULE_NAME = 'diagnosis';

export default [
    {
        name: DIAGNOSIS_INIT,
        path: '/diagnosis/init',
        component: DiagnosisInit,
        meta: {
            roles: [roles.PATIENT],
            tags: [MODULE_NAME],
        }
    },
    {
        name: DIAGNOSIS_STEP,
        path: '/diagnosis/step/:step',
        name: 'diagnosis.step',
        component: DiagnosisSteps,
        meta: {
            alias: 'Autodiagnóstico',
            roles: [roles.PATIENT],
            tags: [MODULE_NAME],
        }
    },
];