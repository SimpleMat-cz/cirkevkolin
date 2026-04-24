import ListSpeakers from './ListSpeakers'
import CreateSpeaker from './CreateSpeaker'
import EditSpeaker from './EditSpeaker'

const Pages = {
    ListSpeakers: Object.assign(ListSpeakers, ListSpeakers),
    CreateSpeaker: Object.assign(CreateSpeaker, CreateSpeaker),
    EditSpeaker: Object.assign(EditSpeaker, EditSpeaker),
}

export default Pages