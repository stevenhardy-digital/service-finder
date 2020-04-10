<template>
    <div class="main-container">
        <div class="row no-gutters">
            <div class="col-sm-4 services-list">
               <div class="location" v-for="location in locations" :key="location.id">
                   <div class="logo">
                       <img :src="location.logo" :alt="location.name" />
                   </div>
                   <div class="details">
                        <h5>{{location.name}}</h5>
                        <p>{{location.location}}</p>
                        <p>{{location.description}}</p>
                   </div>
               </div>
            </div>
            <div class="col-sm-8 map">
                <GoogleMapLoader
                    :mapConfig="mapConfig"
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
                markers: [
                    { id: '1', position: { lat: 51.880087, lng: 0.550927 } }
                ],
                lines: []
            }
        },
        
        async created () {
            await axios
                .get('http://service.test/locations/all')
                .then(response => (
                    this.locations = response.data.locations
                    
                    ));


            this.getMarkers();

        },

        methods: {
            getMarkers() {
                console.log('getting')
                const result = this.locations.map((item) => {
                    return {
                        id: item.id,
                        position: {
                            lat: Number(item.latitude),
                            lng: Number(item.longitude)
                        }
                    };
                });

                this.markers = result;
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
                return this.markers[0].position
            }
        }
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