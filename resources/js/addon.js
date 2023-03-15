/* @deprecated: Alias the Statamic v4 scales so the same classes can work in v3 as well, drop when v3 is dropped */
import '../css/jstw.css';

import Listing from './components/members/Listing.vue'
import Wizard from './components/members/Wizard.vue'
import PublishForm from './components/members/PublishForm.vue'
import Widget from './components/members/Widget.vue'

Statamic.booting(() => {

    Statamic.component('memberbox-members-listing', Listing);
    Statamic.component('memberbox-members-wizard', Wizard);
    Statamic.component('memberbox-members-publish-form', PublishForm);
    Statamic.component('memberbox-members-widget', Widget);

});
