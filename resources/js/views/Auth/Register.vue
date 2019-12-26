<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Registro de usuarios</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form v-model="valid">
                  <v-text-field
                    v-model="name"
                    label="Nombre"
                    :rules="nameRules"
                    required
                    prepend-icon="person"
                    type="text"
                  />
                  <v-text-field
                    v-model="email"
                    label="Email"
                    :rules="emailRules"
                    prepend-icon="person"
                    type="text"
                    required
                  />
                  <v-text-field
                    v-model="password"
                    :rules="passwordRules"
                    :counter="10"
                    label="Contraseña"
                    prepend-icon="lock"
                    type="password"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="primary" @click="register()">Registrarse</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    valid: false,
    email: "",
    emailRules: [
      v => !!v || "Email es necesario",
      v => /.+@.+/.test(v) || "Email debe tener formato valido"
    ],
    name: "",
    nameRules: [v => !!v || "Nombre es necesario"],
    password: "",
    passwordRules: [
      v => !!v || "Contraseña es necesario",
      v =>
        (v || "").length >= 6 || "la contraseña debe tener minimo 6 caracteres",
      v =>
        (v || "").length <= 10 ||
        "la contraseña debe tener maximo 10 caracteres"
    ]
  }),
  methods: {
    async register() {
      axios
        .post("/api/register", {
          email: this.email,
          name: this.name,
          password: this.password
        })
        .then(response =>{
            localStorage.setItem("token", response.data.token);
            this.$router.push("/home");
        })
        .catch(error => {
          console.log(error.response.data);
        });
    }
  }
};
</script>
