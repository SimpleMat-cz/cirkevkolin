import Events from './Events'
import Faqs from './Faqs'
import NewsletterSubscribers from './NewsletterSubscribers'
import Pages from './Pages'
import Series from './Series'
import Sermons from './Sermons'
import SiteSettings from './SiteSettings'
import Speakers from './Speakers'
import Topics from './Topics'
import VisitRequests from './VisitRequests'

const Resources = {
    Events: Object.assign(Events, Events),
    Faqs: Object.assign(Faqs, Faqs),
    NewsletterSubscribers: Object.assign(NewsletterSubscribers, NewsletterSubscribers),
    Pages: Object.assign(Pages, Pages),
    Series: Object.assign(Series, Series),
    Sermons: Object.assign(Sermons, Sermons),
    SiteSettings: Object.assign(SiteSettings, SiteSettings),
    Speakers: Object.assign(Speakers, Speakers),
    Topics: Object.assign(Topics, Topics),
    VisitRequests: Object.assign(VisitRequests, VisitRequests),
}

export default Resources