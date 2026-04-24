import events from './events'
import series from './series'
import sermons from './sermons'
import speakers from './speakers'
import topics from './topics'
import visitRequests from './visit-requests'

const resources = {
    events: Object.assign(events, events),
    series: Object.assign(series, series),
    sermons: Object.assign(sermons, sermons),
    speakers: Object.assign(speakers, speakers),
    topics: Object.assign(topics, topics),
    visitRequests: Object.assign(visitRequests, visitRequests),
}

export default resources