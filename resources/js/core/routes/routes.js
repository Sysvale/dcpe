import AccountMainPage from '../../modules/profile/pages/AccountMainPage';
import InfoMainPage from '../../modules/info/pages/InfoMainPage';
import DiagnosisMainPage from '../../modules/diagnosis/pages/DiagnosisMainPage';
import ProntuaryMainPage from '../../modules/prontuary/pages/ProntuaryMainPage';
import MessagesMainPage from '../../modules/messages/pages/MessagesMainPage';
import HomePage from '../../modules/home/pages/HomePage';

import { 
    NotFoundPage,
} from '../common/';

import HomeRoutes from '../../modules/home/routes';
import MessagesRoutes from '../../modules/messages/routes';

import * as roles from '../constants/userRoles';

export default [
    {
        path: '/',
        name: 'home',
        component: HomePage,
        children: [
            ...HomeRoutes,
        ],
        meta: {
            alias: 'Página Inicial'
        },
    },
    {
        path: '/diagnosis',
        name: 'diagnosis',
        component: DiagnosisMainPage,
        meta: {
            roles: [roles.PATIENT],
            tags: ['modules.diagnosis'],
            alias: 'Autodiagnóstico',
        }
    },
    {
        path: '/info',
        name: 'info',
        component: InfoMainPage,
        meta: {
            roles: [roles.PATIENT],
            tags: ['modules.info'],
            alias: 'Informações',
        }
    },
    {
        path: '/account',
        name: 'account',
        component: AccountMainPage,
        meta: {
            roles: [roles.PATIENT],
            tags: ['modules.account'],
            alias: 'Minha Conta',
        }
    },
    {
        path: '/prontuary',
        name: 'prontuary',
        component: ProntuaryMainPage,
        meta: {
            roles: [roles.PATIENT],
            tags: ['modules.prontuary'],
            alias: 'Meu Prontuário',
        }
    },
    {
        path: '/messages',
        name: 'messages',
        component: MessagesMainPage,
        children: [
            ...MessagesRoutes
        ],
        meta: {
            roles: [roles.PATIENT],
            tags: ['modules.messages'],
            alias: 'Mensagens',
        }
    },
    {
        path: '*',
        name: 'notFound',
        component: NotFoundPage,
        meta: {
            alias: 'Não Encontrado',
        }
    },
];