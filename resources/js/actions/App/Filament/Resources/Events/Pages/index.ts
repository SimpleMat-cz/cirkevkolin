import ListEvents from './ListEvents'
import CreateEvent from './CreateEvent'
import EditEvent from './EditEvent'

const Pages = {
    ListEvents: Object.assign(ListEvents, ListEvents),
    CreateEvent: Object.assign(CreateEvent, CreateEvent),
    EditEvent: Object.assign(EditEvent, EditEvent),
}

export default Pages