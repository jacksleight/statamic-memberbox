<template>
    <div>
        <div v-if="initializing" class="loading">
            <loading-graphic />
        </div>

        <data-list
            v-if="!initializing && items.length"
            :rows="items"
            :columns="cols"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection"
        >
            <div slot-scope="{ }">
                <data-list-table :loading="loading">
                    <template slot="cell-email" slot-scope="{ row: user, value }">
                        <a :href="cp_url(`members/${user.id}`)">
                            {{ value }}
                        </a>                        
                    </template>
                    <template slot="cell-name" slot-scope="{ row: user, value }">
                        {{ value }}
                    </template>
                </data-list-table>
                <data-list-pagination
                    v-if="paginate && meta.last_page != 1"
                    class="py-1 border-t bg-grey-20 rounded-b-lg text-sm"
                    :resource-meta="meta"
                    @page-selected="selectPage"
                    :scroll-to-top="false"
                />
            </div>
        </data-list>

        <p v-else-if="!initializing && !items.length" class="p-2 pt-1 text-sm text-grey-50">
            {{ __('There are no members') }}
        </p>

    </div>
</template>

<script>
export default {

    mixins: [Listing],

    props: {
        paginate: Boolean,
        listingKey: String,
    },

    data() {
        return {
            cols: [
                { label: "Email", field: "email", visible: true },
                { label: "Name", field: "name", visible: true },
            ],
            requestUrl: cp_url(`members`),
        }
    },

}
</script>