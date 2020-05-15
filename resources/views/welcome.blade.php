<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Domino</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">


</head>

<body>
  <div id="app">

    <v-app>

      <v-content>
        <v-container>
          <v-row v-if="loggedIn">
            <v-col cols="12" lg="4" md="4" sm="12">
              <game-index />
            </v-col>
            <v-col cols="12" lg="8" md="8" sm="12">
              <game-show />
            </v-col>

          </v-row>
          <v-row v-else>
            <v-col cols="12" lg="6" md="6" sm="12">
              <login />
              
            </v-col>
            <v-col cols="12" lg="6" md="6" sm="12">
              <register />
            </v-col>

          </v-row>
        </v-container>


      </v-content>

    </v-app>



  </div>



  <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>