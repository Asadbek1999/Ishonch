<template>
    <div>
        <avored-table
            :columns="columns"
            :from="initAttributes.from"
            :to="initAttributes.to"
            :total="initAttributes.total"
            :prev_page_url="initAttributes.prev_page_url"
            :next_page_url="initAttributes.next_page_url"
            :items="initAttributes.data"
            :filerable="true"
            @changeFilter="filterTableData"
        >
            <template slot="name" slot-scope="{ item }">
                <a
                    :href="`${baseUrl}/attribute/${item.id}/edit`"
                    class="text-red-700 hover:text-red-600"
                >
                    {{ item.name }}
                </a>
            </template>
            <template slot="action" slot-scope="{ item }">
                <div class="flex items-center">
                    <a :href="getEditUrl(item)">
                        <svg
                            class="h-6 w-6"
                            fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                class="heroicon-ui"
                                d="M6.3 12.3l10-10a1 1 0 011.4 0l4 4a1 1 0 010 1.4l-10 10a1 1 0 01-.7.3H7a1 1 0 01-1-1v-4a1 1 0 01.3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 012 0v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6c0-1.1.9-2 2-2h6a1 1 0 010 2H4v14h14v-6z"
                            />
                        </svg>
                    </a>

                    <button type="button" @click.prevent="deleteOnClick(item)">
                        <svg
                            class="h-6 w-6"
                            fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                class="heroicon-ui"
                                d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 012 2v2h5a1 1 0 010 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V8H3a1 1 0 110-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 011 1v6a1 1 0 01-2 0v-6a1 1 0 011-1zm4 0a1 1 0 011 1v6a1 1 0 01-2 0v-6a1 1 0 011-1z"
                            />
                        </svg>
                    </button>
                </div>
            </template>
        </avored-table>
    </div>
</template>
<script>
export default {
    props: ["baseUrl", "initAttributes", "filterUrl"],
    data() {
        return {
            columns: [],
            attributes: []
        };
    },
    mounted() {
        this.columns = [
            {
                label: this.$t("system.id"),
                fieldKey: "id",
                visible: true
            },
            {
                label: this.$t("system.name"),
                slotName: "name",
                visible: true
            },
            {
                label: this.$t("system.slug"),
                fieldKey: "slug",
                visible: true
            },
            {
                label: this.$t("system.actions"),
                slotName: "action",
                visible: true
            }
        ];
        this.attributes = this.initAttributes;
    },
    methods: {
        filterTableData(e) {
            let app = this;
            var data = { filter: e.target.value };
            axios.post(this.filterUrl, data).then(response => {
                app.attributes = response.data;
            });
        },
        getEditUrl(record) {
            return this.baseUrl + "/attribute/" + record.id + "/edit";
        },
        getDeleteUrl(record) {
            return this.baseUrl + "/attribute/" + record.id;
        },
        deleteOnClick(record) {
            var url = this.baseUrl + "/attribute/" + record.id;
            var app = this;
            this.$confirm({
                message: `Do you Want to delete ${record.name} attribute?`,
                callback: () => {
                    axios
                        .delete(url)
                        .then(response => {
                            if (response.data.success === true) {
                                app.$alert(response.data.message);
                            }
                            window.location.reload();
                        })
                        .catch(errors => {
                            app.$alert(errors.message);
                        });
                }
            });
        }
    }
};
</script>
