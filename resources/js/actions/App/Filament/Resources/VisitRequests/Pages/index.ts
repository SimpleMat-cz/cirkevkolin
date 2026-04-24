import ListVisitRequests from './ListVisitRequests'
import CreateVisitRequest from './CreateVisitRequest'
import EditVisitRequest from './EditVisitRequest'

const Pages = {
    ListVisitRequests: Object.assign(ListVisitRequests, ListVisitRequests),
    CreateVisitRequest: Object.assign(CreateVisitRequest, CreateVisitRequest),
    EditVisitRequest: Object.assign(EditVisitRequest, EditVisitRequest),
}

export default Pages