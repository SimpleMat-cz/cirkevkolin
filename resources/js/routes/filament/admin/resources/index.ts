import events from './events';
import faqs from './faqs';
import newsletterSubscribers from './newsletter-subscribers';
import pages from './pages';
import series from './series';
import sermons from './sermons';
import siteSettings from './site-settings';
import speakers from './speakers';
import topics from './topics';
import visitRequests from './visit-requests';

const resources = {
    events: Object.assign(events, events),
    faqs: Object.assign(faqs, faqs),
    newsletterSubscribers: Object.assign(
        newsletterSubscribers,
        newsletterSubscribers,
    ),
    pages: Object.assign(pages, pages),
    series: Object.assign(series, series),
    sermons: Object.assign(sermons, sermons),
    siteSettings: Object.assign(siteSettings, siteSettings),
    speakers: Object.assign(speakers, speakers),
    topics: Object.assign(topics, topics),
    visitRequests: Object.assign(visitRequests, visitRequests),
};

export default resources;
