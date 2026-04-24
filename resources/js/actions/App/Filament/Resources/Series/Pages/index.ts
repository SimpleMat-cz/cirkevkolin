import ListSeries from './ListSeries'
import CreateSeries from './CreateSeries'
import EditSeries from './EditSeries'

const Pages = {
    ListSeries: Object.assign(ListSeries, ListSeries),
    CreateSeries: Object.assign(CreateSeries, CreateSeries),
    EditSeries: Object.assign(EditSeries, EditSeries),
}

export default Pages