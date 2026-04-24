import HomeController from './HomeController'
import NedeleController from './NedeleController'
import JsemTuPoprveController from './JsemTuPoprveController'
import KdoJsmeController from './KdoJsmeController'
import CoDelameController from './CoDelameController'
import KazaniController from './KazaniController'
import AkceController from './AkceController'
import KontaktController from './KontaktController'
import PrispetController from './PrispetController'
import VisitRequestController from './VisitRequestController'
import SitemapController from './SitemapController'
import Settings from './Settings'

const Controllers = {
    HomeController: Object.assign(HomeController, HomeController),
    NedeleController: Object.assign(NedeleController, NedeleController),
    JsemTuPoprveController: Object.assign(JsemTuPoprveController, JsemTuPoprveController),
    KdoJsmeController: Object.assign(KdoJsmeController, KdoJsmeController),
    CoDelameController: Object.assign(CoDelameController, CoDelameController),
    KazaniController: Object.assign(KazaniController, KazaniController),
    AkceController: Object.assign(AkceController, AkceController),
    KontaktController: Object.assign(KontaktController, KontaktController),
    PrispetController: Object.assign(PrispetController, PrispetController),
    VisitRequestController: Object.assign(VisitRequestController, VisitRequestController),
    SitemapController: Object.assign(SitemapController, SitemapController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers