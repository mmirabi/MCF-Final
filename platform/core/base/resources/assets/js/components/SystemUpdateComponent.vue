<template>
    <div class="content">
        <slot></slot>

        <div class="text-center" v-if="!performingUpdate">
            <button
                type="button"
                class="btn btn-warning"
                v-if="!askToProcessUpdate"
                @click.prevent="askToProcessUpdate = true"
            >
                <i class="fa me-2" :class="{ 'fa-download': isOutdated, 'fa-refresh': !isOutdated }"></i>
                <span v-if="isOutdated">Download & Install Update</span>
                <span v-else>Re-install The Latest Version</span>
            </button>

            <button type="button" class="btn btn-danger" v-if="askToProcessUpdate" @click="performUpdate">
                <i class="fa fa-check me-2"></i> <span>Click To Confirm!</span>
            </button>
        </div>

        <div class="updating" v-if="performingUpdate">
            <div class="updating-wrapper">
                <div class="updating-container">
                    <div class="loader" v-if="loading">
                        <half-circle-spinner :animation-duration="1000" :size="32" />
                    </div>

                    <div class="percent" v-text="`${percent}%`"></div>

                    <div class="information">
                        <p
                            v-for="result in results"
                            v-text="result.text"
                            :class="result.error ? 'bold text-pink red-shadow' : 'bold'"
                        ></p>
                    </div>

                    <div class="important red-shadow" v-if="loading">
                        <strong>DO NOT CLOSE WINDOWS DURING UPDATE!</strong>
                    </div>

                    <div v-else>
                        <div class="btn btn-info" @click="refresh">Click Here To Exit</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { HalfCircleSpinner } from 'epic-spinners'

export default {
    components: {
        HalfCircleSpinner,
    },

    props: {
        updateUrl: String,
        updateId: String,
        version: String,
        firstStep: String,
        firstStepMessage: String,
        lastStep: String,
        isOutdated: Boolean,
    },

    data() {
        return {
            askToProcessUpdate: false,
            performingUpdate: false,
            results: [],
            realPercent: 0,
            percent: 0,
            percentInterval: 0,
            step: this.firstStep,
            loading: false,
        }
    },

    watch: {
        realPercent() {
            if (this.percentInterval) {
                return
            }

            this.percentInterval = setInterval(() => {
                if (this.percent >= this.realPercent) {
                    return
                }

                if (this.percent === 100) {
                    clearInterval(this.percentInterval)
                    return
                }

                this.percent += 1
            }, 100)
        },
    },

    methods: {
        async performUpdate() {
            this.loading = true
            this.performingUpdate = true
            this.realPercent = 5

            this.results.push({ text: this.firstStepMessage, error: false })

            try {
                await this.triggerUpdate()

                setTimeout(() => this.refresh(), 30000)
            } catch (e) {
                this.loading = false
            }
        },

        async triggerUpdate() {
            return this.$httpClient
                .makeWithoutErrorHandler()
                .post(this.updateUrl, {
                    step_name: this.step,
                    update_id: this.updateId,
                    version: this.version,
                })
                .then(({ data }) => {
                    if (!data.data || !data.data.next_step || !data.data.next_message) {
                        throw new Error('Something went wrong, could not update the system.')
                    }

                    this.step = data.data.next_step
                    this.realPercent = data.data.current_percent
                    this.results.push({ text: data.data.next_message, error: false })

                    if (data.data.next_step !== this.lastStep) {
                        return this.triggerUpdate()
                    }

                    this.percent = 100
                    this.loading = false
                    clearInterval(this.percentInterval)
                })
                .catch((error) => {
                    let message = error.message
                    this.loading = false

                    if (error.data && error.data.message) {
                        message = error.data.message
                    } else if (error.response && error.response.data.message) {
                        message = error.response.data.message
                    }

                    this.results.push({ text: message, error: true })

                    throw error
                })
        },

        refresh() {
            window.location.reload()
        },
    },
}
</script>

<style lang="scss" scoped>
.updating {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9999;
    overflow: hidden;
    backdrop-filter: blur(5px);

    > .updating-wrapper {
        position: absolute;
        top: calc(30% - 100px);
        height: 100%;
        width: 100%;

        > .updating-container {
            max-width: 500px;
            margin: 0 auto;
            text-align: center;

            .percent {
                font-size: 86px;
                color: #fefefe;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New',
                    monospace;
                margin-bottom: 24px;
            }

            .information {
                padding: 0 8px;
                margin: 32px 0;
                font-size: 18px;
                color: #efefef;
            }

            .important {
                color: #efefef;
            }
        }
    }

    .red {
        color: #fdc9c9;
    }

    .red-shadow {
        text-shadow: 0 0 16px #ef0012;
    }
}
</style>
