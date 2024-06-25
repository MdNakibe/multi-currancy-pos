<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col cols="12">
                <v-form ref="branchForm" @submit.prevent="saveBranch" class="custom-form">
                    <v-card class="shadow1 white rounded pb-5">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-toolbar :elevation="0">
                                    <v-toolbar-title class="subtitle-1">Branch Information</v-toolbar-title>
                                </v-toolbar>
                                <v-card-text class="py-2">
                                    <v-row dense justify="center">
                                        <v-col cols="4">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Branch</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="branch.name"
                                                        :rules="[v => !!v]"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Title</v-col>
                                                <v-col cols="9">
                                                    <v-text-field
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="branch.title"
                                                        :rules="[v => !!v]"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Address</v-col>
                                                <v-col cols="9">
                                                    <v-textarea
                                                        dense
                                                        outlined
                                                        hide-details
                                                        v-model.trim="branch.address"
                                                        :rules="[v => !!v]"
                                                    ></v-textarea>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col cols="3"></v-col>
                                                <v-col cols="9">
                                                    <v-row no-gutters>
                                                         <v-col cols="6" class="pr-1">
                                                            <v-btn type="submit" :loading="loading" block class="text_bg_fave">Save</v-btn>
                                                        </v-col>
                                                        <v-col cols="6">
                                                            <v-btn @click="resetForm" dark block color="deep-orange">Clear</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="3">
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3">Logo</v-col>
                                                <v-col cols="9">
                                                    <v-file-input 
                                                        show-size 
                                                        outlined 
                                                        dense
                                                        hide-details
                                                        @change="onChangeMainImage()"
                                                        prepend-icon=""
                                                        prepend-inner-icon="mdi-camera"
                                                    >
                                                    </v-file-input>
                                                </v-col>
                                            </v-row>
                                            <v-row no-gutters class="mb-1">
                                                <v-col cols="3"></v-col>
                                                <v-col cols="9">
                                                   <v-img
                                                        :src="image"
                                                        aspect-ratio="1.2"
                                                        class="grey lighten-2"
                                                        contain
                                                    >
                                                    </v-img>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-form>
            </v-col>
        </v-row>
        <v-row dense class="mt-1">
            <v-col cols="12" class="pb-0">
                <v-data-table
                    class="custom-data-table"
                    :headers="branchHeaders"
                    :loading="$store.getters['branch/loading']"
                    :items="$store.getters['branch/branches']"
                    :search="searchBranch"
                >
                    <template v-slot:top>
                        <v-toolbar dense color="white" :elevation="0">
                            <v-toolbar-title class="subtitle-2">Branch List</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-form class="custom-form">
                                <v-text-field
                                    outlined
                                    dense
                                    hide-details
                                    placeholder="Search branch"
                                    append-icon="mdi-magnify"
                                    style="width:300px;"
                                    v-model="searchBranch"
                                >
                                </v-text-field>
                            </v-form>
                        </v-toolbar>
                    </template>
                    <template v-slot:[`item.action`]="{ item }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="editBranch(item)" color="primary" v-on="on">mdi-circle-edit-outline</v-icon>
							</template>
							<span>Edit</span>
						</v-tooltip>
						<v-tooltip bottom>
							<template v-slot:activator="{ on }">
								<v-icon small @click="branchId = item.id;$refs.confirmDialog.dialog = true" color="error" v-on="on" >mdi-delete-circle-outline</v-icon>
							</template>
							<span>Delete</span>
						</v-tooltip>
					</template>
                </v-data-table>
            </v-col>
        </v-row>
        <confirm-dialog ref="confirmDialog" @confirm="deleteBranch"></confirm-dialog>
    </v-container>
</template>

<script>
import confirmDialog  from './../../components/confirm-dialog.component'

export default {
    name: 'Branch',

    components: {
        'confirm-dialog': confirmDialog,
    },

    data: () => ({
        branchHeaders: [
            { text: 'SL', value: 'sl' },
            { text: 'Branch Name', value: 'name' },
            { text: 'Branch Title', value: 'title' },
            { text: 'Address', value: 'address' },
            { text: 'Action', value: 'action' },
        ],
        searchBranch: '',
        branch: {
            id: null,
            name: '',
            title: '',
            address: '',
        },
        image: '',
        imageFile: null,
        loading: false,
        branchId: null
    }),

    async created() {
        await this.$store.dispatch('branch/getBranches')
    },

    methods: {
        onChangeMainImage() {
            if(event.target.files == undefined || event.target.files.length < 1) {
                this.image = '';
                this.imageFile = null;
                return;
            }

            this.imageFile = event.target.files[0];
            this.image = URL.createObjectURL(event.target.files[0]);
        },

        async saveBranch() {
            if (!this.$refs.branchForm.validate()) return
            this.loading = true;

            let isSuccess = await this.$store.dispatch('branch/saveBranch', {branch: this.branch, image: this.imageFile})
            if(isSuccess) {
                this.resetForm();
            }

            this.loading = false;
        },

        editBranch(branch) {
            Object.keys(this.branch).forEach(key => {
                this.branch[key] = branch[key]
            })
            this.image = `${this.$store.state.hostName}/${branch.image}`
        },

        deleteBranch() {
            this.$store.dispatch('branch/deleteBranch', this.branchId)
            this.$refs.confirmDialog.dialog = false;
        },

        resetForm() {
            Object.keys(this.branch).map(k => this.branch[k] = '')
            this.imageFile = null;
            this.image = '';
            this.branch.id = null;
            this.$refs.branchForm.reset();
            this.$refs.branchForm.resetValidation();
        }
    }
}
</script>

<style>

</style>