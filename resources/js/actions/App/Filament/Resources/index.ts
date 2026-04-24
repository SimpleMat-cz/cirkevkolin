import Events from './Events'
import Series from './Series'
import Sermons from './Sermons'
import Speakers from './Speakers'
import Topics from './Topics'
import VisitRequests from './VisitRequests'

const Resources = {
    Events: Object.assign(Events, Events),
    Series: Object.assign(Series, Series),
    Sermons: Object.assign(Sermons, Sermons),
    Speakers: Object.assign(Speakers, Speakers),
    Topics: Object.assign(Topics, Topics),
    VisitRequests: Object.assign(VisitRequests, VisitRequests),
}

export default Resources