<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6" class="pb-0 shadow1 white rounded px-4 py-5">
                <v-data-table
                    class="custom-data-table"
                    :headers="monthHeaders"
                    :items="$store.getters['month/months']"
                    :search="searchMonth"
                    :loading="$store.getters['month/loading']" 
					loading-text="Loading... Please wait"
                >
                    <template v-slot:top>
                        <v-toolbar
                            dense
                            color="white"
                            :elevation="0"
                            height="50"
                        >
                            <v-toolbar-title class="subtitle-1"
                                >Month List</v-toolbar-title
                            >
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search month"
                                    append-icon="mdi-magnify"
                                    style="width: 300px"
                                    v-model="searchMonth"
                                >
                                </v-text-field>
                            </v-form>
                            <v-spacer></v-spacer>
                            <month-dialog :icon="true" ref="monthDialog"></month-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }" v-if="userType == 'super_admin' || userType == 'admin'">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="editMonth(item)"
                                    color="primary"
                                    v-on="on"
                                    >mdi-circle-edit-outline</v-icon
                                >
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-icon
                                    small
                                    @click="monthId = item.id;$refs.confirmDialog.dialog = true"
                                    color="error"
                                    v-on="on"
                                    >mdi-delete-circle-outline</v-icon
                                >
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
                <confirm-dialog ref="confirmDialog" @confirm="deleteMonth"></confirm-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import confirmDialog from "../../components/confirm-dialog.component";
import monthDialog from "../../components/month-dialog.component";

export default {
    name: 'Months',

    components: {
		"confirm-dialog": confirmDialog,
		"month-dialog": monthDialog,
	},

    data: () => ({
        monthHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Month Name', value: 'name' },
            { text: 'Action', value: 'action' },
        ],
        searchMonth: "",
        monthId: null,
        loading: false,
        userType: ''
    }), 
    
    async created() {
        await this.$store.dispatch("month/getMonths");
        let userData = JSON.parse(localStorage.getItem('userData'))
		this.userType = userData.userType;
    },

    methods: {
        editMonth(month){
            Object.keys(this.$refs.monthDialog.month).forEach(key => {
                this.$refs.monthDialog.month[key] = month[key];
            })
            this.$refs.monthDialog.showMonthDialog = true;
        },

        deleteMonth(){
            this.$store.dispatch('month/deleteMonth', this.monthId);
            this.$refs.confirmDialog.dialog = false;
        }
    }
}
</script>

<style>

</style>