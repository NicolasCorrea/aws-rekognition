    <template>
  <div>
    <v-app>
      <v-navigation-drawer v-model="drawer" app clipped>
        <v-list dense nav>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            @click="goTo(item.link)"
            active-class="isActive"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-app-bar app clipped-left>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>LaraVue</v-toolbar-title>
      </v-app-bar>

      <v-content>
        <v-container fluid fill-height>
          <v-layout justify-center>
            <v-flex shrink>
              <div>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis, dolores similique, esse amet corrupti ducimus est dicta voluptatum dolor odio delectus quisquam non atque deleniti mollitia magni
                  eveniet debitis. Velit.
                </p>
              </div>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>

      <v-footer app>
        <span>&copy; 2019</span>
      </v-footer>
    </v-app>
  </div>
</template>
