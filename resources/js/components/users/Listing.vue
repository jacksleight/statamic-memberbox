    <template>
    <div>

        <div v-if="initializing" class="card loading">
            <loading-graphic />
        </div>

        <data-list
            v-if="!initializing"
            :columns="columns"
            :rows="items"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection"
        >
            <div slot-scope="{ hasSelections }">
                <div class="card p-0 relative">
                    <div class="data-list-header">
                        <data-list-search v-model="searchQuery" />
                    </div>
                    <div v-show="items.length === 0" class="p-3 text-center text-grey-50" v-text="__('No results')" />
                    <data-list-bulk-actions
                        class="rounded"
                        :url="actionUrl"
                        @started="actionStarted"
                        @completed="actionCompleted"
                    />
                    <data-list-table :allow-bulk-actions="false" v-show="items.length" @sorted="sorted">
                        <template slot="cell-email" slot-scope="{ row: user, value }">
                            <a :href="cp_url(`members/${user.id}`)">
                                {{ value }}
                            </a>
                        </template>
                        <template slot="actions" slot-scope="{ row: user, index }">
                            <dropdown-list>
                                <dropdown-item :text="__('Edit')" :redirect="cp_url(`members/${user.id}`)" v-if="user.editable" />
                                <data-list-inline-actions
                                    :item="user.id"
                                    :url="actionUrl"
                                    :actions="filterActions(user.actions)"
                                    @started="actionStarted"
                                    @completed="actionCompleted"
                                />
                            </dropdown-list>
                        </template>
                    </data-list-table>
                </div>

                <data-list-pagination
                    class="mt-3"
                    :resource-meta="meta"
                    :per-page="perPage"
                    @page-selected="selectPage"
                    @per-page-changed="changePerPage"
                />
            </div>
        </data-list>

    </div>
</template>

<script>
import Listing from '/vendor/statamic/cms/resources/js/components/Listing.vue';

export default {

    mixins: [Listing],

    props: {
        listingKey: String,
    },

    data() {
        return {
            requestUrl: cp_url('members'),
        }
    },

    methods: {

        filterActions(actions) {
            const i = actions.findIndex(action => action.handle === 'send_password_reset');
            return [
                ...actions.slice(0, i),
                ...actions.slice(i + 1)
            ];
        }

    }

}
</script>