<template>
    <div class="main-container">
        <div class="row no-gutters">
            <div class="col-sm-3 services-list">
               <div class="location" v-for="location in locations">
                   <div class="logo">
                       <img :src="location.logo" :alt="location.name" />
                   </div>
                   <div class="details">
                        <h5>{{location.name}}</h5>
                        <p>{{location.location}}</p>
                   </div>
               </div>
            </div>
            <div class="col-sm-9 map">
                <GoogleMapLoader
                    :mapConfig="mapConfig"
                    :apiKey="this.apiKey"
                >
                    <template slot-scope="{ google, map }">
  	                    <GoogleMapMarker
                            v-for="marker in markers"
                            :key="marker.id"
                            :marker="marker"
                            :google="google"
                            :map="map"
                        />
                        <GoogleMapLine
                            v-for="line in lines"
                            :key="line.id"
                            :path.sync="line.path"
                            :google="google"
                            :map="map"
                        />
                    </template>
                </GoogleMapLoader>
            </div>
        </div>
    </div>
</template>

<script>
    import GoogleMapLoader from './GoogleMapsComponent'
    import GoogleMapMarker from './GoogleMapMarker'
    import GoogleMapLine from './GoogleMapLine'
    import { mapSettings } from '../constants/mapSettings'

    export default {
        components: {
            GoogleMapLoader,
            GoogleMapMarker,
            GoogleMapLine
        },

        data() {
            return {
                locations: [],
                apiKey: process.env.MIX_GOOGLE_API,
                markers: [
                    { id: 'a', position: { lat: 3, lng: 101 } },
                    { id: 'b', position: { lat: 5, lng: 99 } },
                    { id: 'c', position: { lat: 6, lng: 97 } },
                ],
                lines: [
                    { id: '1', path: [{ lat: 3, lng: 101 }, { lat: 5, lng: 99 }] },
                    { id: '2', path: [{ lat: 5, lng: 99 }, { lat: 6, lng: 97 }] }
                ],
            }
        },

        computed: {
            mapConfig () {
                return {
                    ...mapSettings,
                    center: this.mapCenter
                }
            },
            mapCenter () {
                return this.markers[1].position
            }
        },
         mounted () {
            axios
            .get('http://service.test/locations/all')
            .then(response => (this.locations = response.data.locations))
        },
    }
</script>

<style scoped lang='scss'>
  .google-map {
    display: flex;
    justify-content: center;
    align-items: center;
    &__map {
      height: 460px;
      width: 100%;
    }
    &__placeholder {
      height: 460px;
      width: 100%;
    }
  }
</style>