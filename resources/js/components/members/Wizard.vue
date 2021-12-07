<template>
    <div class="max-w-xl mx-auto rounded shadow bg-white">
        <div class="max-w-lg mx-auto pt-6 relative">
            <div class="wizard-steps">
                <a class="step" :class="{'complete': currentStep >= index}" v-for="(step, index) in steps" @click="goToStep(index)">
                    <div class="ball">{{ index+1 }}</div>
                    <div class="label">{{ step }}</div>
                </a>
            </div>
        </div>

        <!-- Step 1 -->
        <div v-if="!completed && currentStep === 0">
            <div class="max-w-md mx-auto px-2 py-6 text-center">
                <h1 class="mb-3">{{ __('Create Member') }}</h1>
                <p class="text-grey" v-text="__('statamic-memberbox::messages.member_wizard_intro')" />
            </div>

            <div class="max-w-md mx-auto px-2 pb-6">
                <div class="-m-3">
                    <publish-container
                        v-if="fields.length"
                        ref="container"
                        :name="publishContainer"
                        :blueprint="fieldset"
                        :values="values"
                        :meta="meta"
                        :errors="errors"
                        @updated="values = $event"
                    >
                        <publish-fields
                            slot-scope="{ setFieldValue, setFieldMeta }"
                            :fields="fields"
                            @updated="setFieldValue"
                            @meta-updated="setFieldMeta"
                        />
                    </publish-container>
                </div>
            </div>
            
        </div>

        <!-- Step 2 -->
        <div v-if="!completed && currentStep === 1">
            <div class="max-w-md mx-auto px-2 py-6 text-center">
                <h1 class="mb-3">{{ __('Invitation') }}</h1>
                <p class="text-grey" v-text="__('statamic-memberbox::messages.member_wizard_invitation_intro')" />
            </div>

            <!-- Send Email? -->
            <div class="max-w-md mx-auto px-2 mb-3 flex items-center">
                <toggle-input v-model="invitation.send" />
                <label class="font-bold ml-1">{{ __('Send Email Invitation') }}</label>
            </div>

            <div class="max-w-lg mx-auto bg-grey-10 py-5 mb-7 border rounded-lg " v-if="invitation.send">
                <!-- Subject Line -->
                <div class="max-w-md mx-auto px-2 pb-5">
                    <label class="font-bold text-base mb-sm" for="email">{{ __('Email Subject') }}</label>
                    <input type="text" v-model="invitation.subject" class="input-text bg-white">
                </div>

                <!-- Email Content -->
                <div class="max-w-md mx-auto px-2">
                    <label class="font-bold text-base mb-sm" for="email">{{ __('Email Content') }}</label>
                    <textarea
                        class="input-text min-h-48 p-2 bg-white"
                        v-model="invitation.message"
                        v-elastic
                    />
                </div>
            </div>

            <!-- Copy Pasta -->
            <div class="max-w-md mx-auto px-2 pb-7" v-else>
                <p class="mb-1" v-html="__('statamic-memberbox::messages.member_wizard_invitation_share_before', { email: values.email })" />
            </div>
        </div>

        <!-- Post creation -->
        <div v-if="completed">
            <div class="max-w-md mx-auto px-2 py-6 text-center">
                <h1 class="mb-3">{{ __('Member Created') }}</h1>
                <p class="text-grey" v-html="__('statamic-memberbox::messages.member_wizard_account_created')" />
            </div>

            <!-- Copy Pasta -->
            <div class="max-w-md mx-auto px-2 pb-7">
                <p class="mb-1" v-html="__('messages.user_wizard_invitation_share', { email: values.email })" />
                <textarea readonly class="input-text" v-elastic onclick="this.select()">
{{ __('Activation URL') }}: {{ activationUrl }}

{{ __('Username') }}: {{ values.email }}
</textarea>
            </div>
        </div>

        <div class="border-t p-2">
            <div class="max-w-md mx-auto flex items-center justify-center">
                <button tabindex="3" class="btn mx-2 w-32" @click="previous" v-if="! completed && ! onFirstStep">
                    &larr; {{ __('Previous')}}
                </button>
                <button tabindex="4" class="btn mx-2 w-32" :disabled="! canContinue" @click="next" v-if="! completed && ! onLastStep">
                    {{ __('Next')}} &rarr;
                </button>
                <button tabindex="4" class="btn-primary mx-2" @click="submit" v-if="! completed && onLastStep">
                    {{ finishButtonText }}
                </button>
                <a :href="usersIndexUrl" class="btn mx-2" v-if="completed">
                    {{ __('Back to Members') }}
                </a>
                <a :href="usersCreateUrl" class="btn-primary mx-2" v-if="completed">
                    {{ __('Create Another') }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
// Yer a wizard Ron

import isEmail from 'validator/lib/isEmail';
import HasWizardSteps from '/vendor/statamic/cms/resources/js/components/HasWizardSteps.js';

export default {

    mixins: [HasWizardSteps],

    props: {
        publishContainer: String,
        initialFieldset: Object,
        initialFields: Array,
        initialValues: Object,
        initialMeta: Object,
        route: { type: String },
        usersCreateUrl: { type: String },
        usersIndexUrl: { type: String },
        activationExpiry: { type: Number },
    },

    data() {
        return {
            fieldset: _.clone(this.initialFieldset),
            fields: _.clone(this.initialFields),
            values: _.clone(this.initialValues),
            meta: _.clone(this.initialMeta),
            error: null,
            errors: {},
            steps: [__('Member Information'), __('Customize Invitation')],
            invitation: {
                send: true,
                subject: __('statamic-memberbox::messages.invitation_subject', { site: window.location.hostname }),
                message: __('statamic-memberbox::messages.invitation_body', { site: window.location.hostname, expiry: this.activationExpiry }),
            },
            completed: false,
            activationUrl: null,
            editUrl: null,
        }
    },

    computed: {
        finishButtonText() {
            return this.invitation.send ? __('Create and Send Email') : __('Create Member');
        },
        isValidEmail() {
            return this.values.email && isEmail(this.values.email)
        },
        hasErrors() {
            return this.error || Object.keys(this.errors).length;
        }
    },

    methods: {
        canGoToStep(step) {
            if (this.completed) return false;

            if (step >= 1) {
                return this.isValidEmail;
            }

            return true;
        },
        clearErrors() {
            this.error = null;
            this.errors = {};
        },
        submit() {
            this.clearErrors();

            let payload = {...this.values, invitation: this.invitation};

            this.$axios.post(this.route, payload).then(response => {
                if (this.invitation.send) {
                    window.location = response.data.redirect;
                } else {
                    this.completed = true;
                    this.editUrl = response.data.redirect;
                    this.activationUrl = response.data.activationUrl;
                }
            }).catch(e => {
                this.currentStep = 0;
                this.$nextTick(() => {
                    if (e.response && e.response.status === 422) {
                        const { message, errors } = e.response.data;
                        this.error = message;
                        this.errors = errors;  
                        this.$toast.error(message);
                    } else {
                        this.$toast.error(__('Something went wrong'));
                    }
                });
            });
        }
    },

    mounted() {
        this.$keys.bindGlobal(['command+return'], e => {
            this.next();
        });

        this.$keys.bindGlobal(['command+delete'], e => {
            this.previous();
        });
    }

}
</script>