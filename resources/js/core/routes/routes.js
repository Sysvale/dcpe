import AccountMainPage from '../../modules/profile/pages/AccountMainPage';
import InfoMainPage from '../../modules/info/pages/InfoMainPage';
import DiagnosisMainPage from '../../modules/diagnosis/pages/DiagnosisMainPage';
import ProntuaryMainPage from '../../modules/prontuary/pages/ProntuaryMainPage';
import MessagesMainPage from '../../modules/messages/pages/MessagesMainPage';
import HomePage from '../../modules/home/pages/HomePage';
import ProfessionalView from '../../modules/prontuary/pages/ProfessionalView';
import ChatFollowUp from '../../modules/messages/pages/ChatFollowUp';

import { 
    NotFoundPage,
} from '../common/';

import MessagesRoutes from '../../modules/messages/routes';
import DiagnosisRoutes from '../../modules/diagnosis/routes';
import ProntuaryRoutes from '../../modules/prontuary/routes';

import * as roles from '../constants/userRoles';

export default [
    {
        path: '/',
        name: 'home',
        component: HomePage,
        meta: {
            alias: 'Página Inicial'
        },
    },
    {
        path: '/info',
        name: 'info',
        component: InfoMainPage,
        meta: {
            roles: [roles.PATIENT, roles.PROFESSIONAL],
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
        path: '/prontuary/home',
        name: 'prontuary',
        component: ProntuaryMainPage,
        children: [
            ...ProntuaryRoutes,
        ],
        meta: {
            roles: [roles.PATIENT],
            tags: ['modules.prontuary'],
            alias: 'Meu Prontuário',
        }
    },
    {
        path: '/prontuary/:id/view',
        name: 'prontuary.view',
        component: ProfessionalView,
        meta: {
            roles: [roles.PROFESSIONAL],
            tags: ['modules.prontuary.view'],
            alias: 'Prontuário',
        },
    },
    {
        path: '/message/:id/chat/:chat',
        name: 'message.patient',
        component: ChatFollowUp,
        meta: {
            roles: [roles.PROFESSIONAL],
            tags: ['modules.message.patient'],
            alias: 'Acompanhamento',
        },
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