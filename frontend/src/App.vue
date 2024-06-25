<template>
	<component :is="layout"></component>
</template>

<script>
import defaultLayout from './layouts/Default';
import simpleLayout from './layouts/Simple';
import PosLayout from './layouts/PosLayout.vue';
export default {
	components: {
		defaultLayout,
		simpleLayout,
		PosLayout,
	},

	computed: {
		layout () {
			if (!localStorage.getItem('jwtToken')) {
				return 'simpleLayout';
			} else {
				return this.$route.meta.layout || 'defaultLayout';
			}
		}
	},
}
</script>

<style>

</style>