import {
    ChatMessage,    
} from './pages';

import Questions from './components/Questions';
import FollowUpRequests from './pages/FollowUpRequests';
import * as roles from '../../core/constants/userRoles';

export const DOUBT_MESSAGES = 'doubt.messages';
export const FOLLOW_REQUEST = 'follow.request';
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
    },
    {
        name: DOUBT_MESSAGES,
        path: '/messages/doubts',
        component: Questions,
        meta: {
            roles: [roles.PROFESSIONAL],
            tags: [MODULE_NAME],
        },
    },
    {
        name: FOLLOW_REQUEST,
        path: '/messages/follow-up/requests',
        component: FollowUpRequests,
        meta: {
            roles: [roles.PROFESSIONAL],
            tags: [MODULE_NAME],
        },
    }

];