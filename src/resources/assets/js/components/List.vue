<template>

    <v-container grid-list-md>


        <v-layout row wrap>
            <v-flex xs10 offset-xs1>
                <div class="component-header">Notes({{ notesLength }})</div>

                <v-data-table

                        v-if="notesLength"

                        :headers="headers"
                        :items="notes"
                        hide-actions >
                    <template
                            slot="headerCell"
                            slot-scope="{ header }" >
                        <span  class="subheading font-weight-light text-success text--darken-3" />
                    </template>

                    <template
                            slot="items"
                            slot-scope="{ item }">
                        <td v-if="item.photo">
                            <img :src=" 'images/'+item.photo " @error="aVueFunctionThatChangesTheSrc" style="width:70%"/>
                        </td>
                        <td v-else>
                            <img src="images/default.png" class="img-thumbnail img-responsive" style="width:10%"/>
                        </td >

                        <td>
                            <span v-if="currentEditingId !== item.id">{{ item.title }} </span>
                        </td>
                        <td>
                            <span v-if="currentEditingId !== item.id">{{ item.email }}  </span>
                        </td>
                        <td>
                        <input type="text" v-if="currentEditingId === item.id && editing" :placeholder="item.title"
                               v-model="editedTitle">
                        </td>

                        <div v-if="currentUser">
                            <td>
                                <v-btn icon href="#!" @click="deleteNote(item.id)">
                                    <v-icon>delete</v-icon>
                                </v-btn>
                            </td>
                            <td>
                                <v-btn icon href="#!" @click="edit(item.id)" v-if="currentEditingId !== item.id">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                            </td>
                            <td>
                                <v-btn icon href="#!" @click="update(item.id, item.title)" v-if="currentEditingId === item.id">
                                    <v-icon>done</v-icon>
                                </v-btn>
                            </td>
                            <td><input type="checkbox" v-model="item.is_favourite" v-bind:id="item.id" @click="toggleFavourite(item.id, item.is_favourite)"></td>
                        </div>
                    </template>
                </v-data-table>
                <div v-else>No Notes Found</div>

            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: 'List',
        data() {
          return {
              editing: false,
              currentEditingId: 0,
              editedTitle: ''
          }
        },
        mounted() {
            this.$store.dispatch('fetch');
        },
        methods: {
          deleteNote(id) {
              this.$store.dispatch('deleteNote', id);
              flash('Note Successfully Deleted.');
          },
          edit(id) {
              this.editing=true;
              this.currentEditingId = id;
          },
          update(id, previousTitle) {
              this.currentEditingId = 0;
              this.$store.dispatch('edit', {id: id, title:  this.editedTitle ? this.editedTitle : previousTitle});
              this.editing = false;
              flash('Note Successfully Edited.');
          },
            toggleFavourite(id, is_favourite) {
            this.$store.dispatch('toggleFavourite', id);
            const message = is_favourite ? 'Unfavourited Successfully' :'Favourited successfully.';
            flash(message);
          },
            favouriteClass(isFavourite) {
                const heartIcon = 'glyphicon glyphicon-heart';
                return isFavourite ? heartIcon : `${heartIcon}-empty`;
            },
            favouriteTitle(isFavourite) {
                return isFavourite ? 'Unfavourite' : 'Favourite';
            }
        },
        computed: {
            ...mapState(['notes']),
            notesLength() {
                return this.notes.length;
            },

            //aVueFunctionThatChangesTheSrc() {
             //   return this.notes.length;
            //},

            currentUser(){
                //return this.$store.getters.currentUser
                return this.$store.state.currentUser
            }
        }
    }
</script>