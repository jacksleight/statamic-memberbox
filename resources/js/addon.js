import Listing from './components/users/Listing.vue'
import Wizard from './components/users/Wizard.vue'
import PublishForm from './components/users/PublishForm.vue'
import Widget from './components/users/Widget.vue'

Statamic.booting(() => {

    Statamic.component('members-user-listing', Listing);
    Statamic.component('members-user-wizard', Wizard);
    Statamic.component('members-user-publish-form', PublishForm);
    Statamic.component('members-user-widget', Widget);

});
