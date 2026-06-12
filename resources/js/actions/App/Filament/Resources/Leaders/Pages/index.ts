import ListLeaders from './ListLeaders';
import CreateLeader from './CreateLeader';
import EditLeader from './EditLeader';

const Pages = {
    ListLeaders: Object.assign(ListLeaders, ListLeaders),
    CreateLeader: Object.assign(CreateLeader, CreateLeader),
    EditLeader: Object.assign(EditLeader, EditLeader),
};

export default Pages;
