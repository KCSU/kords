<template>
	<transition name="fade">
		<div
			v-if="showing"
			class="fixed inset-0 w-full h-screen flex items-center justify-center bg-smoke-800 z-50"
			@click.self="closeIfShown"
			:class="customCSS.background"
		>
			<div
				class="relative max-h-screen w-full max-w-3xl bg-white shadow-lg rounded-lg py-8 px-1.5 flex"
				:class="customCSS.modal"
			>
				<button
					v-if="showClose"
					aria-label="close"
					class="absolute top-0 right-0 text-3xl text-gray-500 my-2 mx-4"
					:class="customCSS.close"
					@click.prevent="close"
				>
					×
				</button>
				<div class="overflow-auto max-h-screen w-full">
					<slot />
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
		props: {
			showing: {
				required: true,
				type: Boolean
			},
			showClose: {
				type: Boolean,
				default: true
			},
			backgroundClose: {
				type: Boolean,
				default: true,
			},
			css: {
				type: Object,
				required: false
			}
		},
		computed: {
			customCSS() {
				return {...{
					background: '',
					modal: '',
					close: ''
				}, ...this.css}
			}
		},
		watch: {
			showing(value) {
				if (value) {
					return document.querySelector("body").classList.add("overflow-hidden");
				}
				return document.querySelector("body").classList.remove("overflow-hidden");
			}
		},
		methods: {
			close() {
				document.querySelector("body").classList.remove("overflow-hidden");
				this.$emit("close");
			},
			closeIfShown() {
				if (this.showClose && this.backgroundClose) {
					this.close();
				}
			}
		},
		mounted: function() {
			if (this.showClose) {
				document.addEventListener("keydown", e => {
					if (e.key === "Escape") {
						this.close();
					}
				});
			}
		}
	};
</script>

<style scoped>
	.fade-enter-active,
	.fade-leave-active {
		transition: all 0.6s;
	}
	.fade-enter,
	.fade-leave-to {
		opacity: 0;
	}
</style>