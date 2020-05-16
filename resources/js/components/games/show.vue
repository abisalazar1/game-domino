<template>
  <div>
    <v-card v-if="game">
      <v-card-title>
        Game {{ game.id }}
        <v-spacer />
        <span v-if="!game.winner">Current Turn: {{game.current_turn.username}}</span>
        <span v-else>Winner: {{game.winner.username}}</span>
      </v-card-title>

      <v-card-text>
        <v-list-item v-for="turn in game.turns" :key="turn.id">
          <v-list-item-content>
            <v-list-item-title>
              {{ turn.player.username }} has played a tile
              <span
                class="font-weight-bold title"
              >{{ turn.tile.left_side }} : {{ turn.tile.right_side}}</span>
            </v-list-item-title>
            <v-list-item-subtitle>Left Ends In {{ turn.left_pile_ends_in }} and Right Ends In {{ turn.right_pile_ends_in }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-card-text>

      <v-card-actions class="d-flex flex-wrap">
        <span v-if="!game.winner">Current Turn: {{game.current_turn.username}}</span>
        <span v-else>Winner: {{game.winner.username}}</span>
        <div class="ma-2">Players: {{game.players_count}}</div>
        <div class="ma-2">Tiles in pool: {{game.tiles_in_pool}}</div>
        <div class="ma-2">Played Tiles: {{game.tiles_played}}</div>

        <v-spacer />
        <div class="ma-2">
          <v-btn @click="skip">Skip Turn</v-btn>
        </div>
        <div class="ma-2">
          <v-btn @click="draw">Draw Tile</v-btn>
        </div>
      </v-card-actions>
      <v-card-actions class="d-flex flex-wrap">
        <div class="ma-2" v-for="tile in game.my_hand" :key="tile.id">
          <v-btn
            class="font-weight-bold"
            @click="playTile(tile)"
          >{{tile.left_side}} : {{tile.right_side}}</v-btn>
        </div>
      </v-card-actions>
    </v-card>
    <v-card v-else>
      <v-card-title>Select a game</v-card-title>
    </v-card>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import formActions from "@/mixins/formActions";

export default {
  name: "gameShow",
  data: () => ({
    game: null
  }),
  mixins: [formActions],
  methods: {
    getGame({ id }) {
      if (!id) return;
      this.$api.get(`games/${id}`).then(({ data }) => {
        this.game = data;
      });
    },
    draw() {
      this.$api
        .post(`games/${this.game.id}/turns/draw`)
        .then(({ data }) => {
          this.getGame(this.game);
          this.resetFormErrors();
        })
        .catch(({ data }) => {
          this.setFormErrors(data);
          if (this.formHasError("game")) {
            Swal.fire({
              icon: "error",
              text: this.formGetError("game")
            });
          }
        });
    },
    skip() {
      this.$api
        .post(`games/${this.game.id}/turns/skip`)
        .then(({ data }) => {
          this.getGame(this.game);
          this.resetFormErrors();
        })
        .catch(({ data }) => {
          this.setFormErrors(data);
          if (this.formHasError("game")) {
            Swal.fire({
              icon: "error",
              text: this.formGetError("game")
            });
          }
        });
    },
    playTile(tile) {
      Swal.fire({
        title: "Select Left Or Right Pile",
        input: "select",
        inputOptions: {
          left: "left",
          right: "right"
        },
        inputPlaceholder: "Select Pile",
        inputAttributes: {
          autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Play",
        showLoaderOnConfirm: true,
        preConfirm: side => {
          return this.$api
            .post(`games/${this.game.id}/turns`, {
              tile_id: tile.id,
              side
            })
            .then(({ data }) => {
              this.getGame(this.game);
              this.resetFormErrors();
            })
            .catch(({ data }) => {
              this.setFormErrors(data);
              if (this.formHasError("tile_id")) {
                Swal.showValidationMessage(
                  `Request failed: ${this.formGetError("tile_id")}`
                );
              }

              if (this.formHasError("side")) {
                Swal.showValidationMessage(
                  `Request failed: ${this.formGetError("side")}`
                );
              }
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
      });
    }
  },
  created() {
    Bus.$on("showGame", payload => {
      this.getGame(payload);
    });

    setInterval(() => {
      this.getGame(this.game || {});
    }, 5000);
  }
};
</script>
