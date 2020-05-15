<template>
  <v-card>
    <v-card-title>
      Games
      <v-spacer />
      <v-btn @click="create">New Game</v-btn>
    </v-card-title>
    <v-card-text>
      <v-list-item v-for="game in games" :key="game.id" @click="showGame(game)">
        <v-list-item-content>
          <v-list-item-title>Game {{ game.id }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-card-text>
  </v-card>
</template>

<script>
import formActions from "@/mixins/formActions";
import Swal from "sweetalert2";

export default {
  name: "gameIndex",
  data: () => ({
    games: []
  }),
  mixins: [formActions],
  methods: {
    getList() {
      this.$api
        .get("games")
        .then(({ data }) => {
          this.games = data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    create() {
      Swal.fire({
        title: "Add Players code ID separeted by a comma example: 1,2,3,4",
        input: "text",
        inputAttributes: {
          autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Create Game",
        showLoaderOnConfirm: true,
        preConfirm: players => {
          return this.$api
            .post("games", {
              players: players.split(",")
            })
            .then(({ data }) => {
              Bus.$emit("showGame", data);
              this.getList();
            })
            .catch(({ data }) => {
              this.setFormErrors(data);
              Swal.showValidationMessage(
                `Request failed: ${this.formGetError("players")}`
              );
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
      });
    },
    showGame(game) {

      Bus.$emit("showGame", game);
    }
  },
  created() {
    this.getList();
  }
};
</script>

<style>
</style>