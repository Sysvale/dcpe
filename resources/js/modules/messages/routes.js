import {
    ChatMessage,    
} from './pages';

import * as roles from '../../core/constants/userRoles';

export const HOME_MESSAGES = 'home.messages';
export const CHAT_MESSAGE = 'chat.message';

const MODULE_NAME = 'messages';

export default [
    {
        name: CHAT_MESSAGE,
        path: '/messages/:id',
        component: ChatMessage,
        meta: {
            roles: [roles.PATIENT],
            tags: [MODULE_NAME],
        },
    }
];