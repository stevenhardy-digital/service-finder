<template>
    <div>
        <div class="google-map" ref="googleMap"></div>
        <template v-if="Boolean(this.google) && Boolean(this.map)">
        <slot
            :google="google"
            :map="map"
        />
        </template>
    </div>
</template>

<script>
    import GoogleMapsApiLoader from 'google-maps-api-loader'
    
    export default {
        props: {
            mapConfig: Object,
        },
        data() {
            return {
                google: null,
                map: null
            }
        },
        async created() {
            const googleMapApi = await GoogleMapsApiLoader({
            apiKey: process.env.MIX_GOOGLE_API
            })
            this.google = googleMapApi
            this.initializeMap()
        },

        methods: {
            initializeMap() {
            const mapContainer = this.$refs.googleMap
            this.map = new this.google.maps.Map(mapContainer, this.mapConfig)
            }
        }
    }
</script>