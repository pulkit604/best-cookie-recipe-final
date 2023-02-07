<template>
  <div>
    <v-card
        class="mx-auto"
        max-width="800"
    >
      <v-img
          src="https://www.rd.com/wp-content/uploads/2017/06/milk-and-cookies-GettyImages-1058142596-MLedit.jpg"
          height="600px"
          cover
      ></v-img>

      <v-card-title>
        Let us find the best milk-dunking cookie recipe!
      </v-card-title>

      <v-card-actions>
        <v-btn
            color="orange-lighten-2"
            variant="text"
        >
          Input Ingredients:
        </v-btn>

        <v-spacer></v-spacer>

        <v-btn
            :icon="show ? 'mdi-chevron-up' : 'mdi-chevron-down'"
            @click="show = !show"
        ></v-btn>
      </v-card-actions>

      <v-expand-transition>
        <div v-show="show">
          <v-divider></v-divider>

          <v-card-text>
            <v-table
                fixed-header
                height="300px"
            >
              <thead>
              <tr>
                <th class="text-left">
                  Ingredient Name
                </th>
                <th class="text-left">
                  Capacity
                </th>
                <th class="text-left">
                  Durability
                </th>
                <th class="text-left">
                  Flavor
                </th>
                <th class="text-left">
                  Texture
                </th>
                <th class="text-left">
                  Calories
                </th>
              </tr>
              </thead>
              <tbody>
                <tr
                    v-for="item in ingredients"
                    :key="item.name"
                >
                  <td><v-text-field label="Name" type="text" v-model="item.name"></v-text-field></td>
                  <td><v-text-field label="Capacity" type="number" v-model="item.capacity"></v-text-field></td>
                  <td><v-text-field label="Durability" type="number" v-model="item.durability"></v-text-field></td>
                  <td><v-text-field label="Flavor" type="number" v-model="item.flavor"></v-text-field></td>
                  <td><v-text-field label="Texture" type="number" v-model="item.texture"></v-text-field></td>
                  <td><v-text-field label="Calories" type="number" v-model="item.calories"></v-text-field></td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </div>
      </v-expand-transition>
      <v-btn
          color="secondary"
          class="ma-1"
          @click="addIngredient()"
      >
        Add Row
      </v-btn>
      <v-divider></v-divider>
      <v-btn
          color="primary"
          class="ma-1"
          @click="getHighestScore()"
      >
        Get Highest Score
      </v-btn>
      <v-divider></v-divider>
      <v-text-field label="Desired Calorie Amount" v-model="calorieVal"></v-text-field>
      <v-btn
          color="secondary"
          class="ma-1"
          @click="getHighestScore(true)"
      >
        Get Highest Score Using Calorie
      </v-btn>
    </v-card>
    <v-dialog
        v-model="dialog"
    >
      <v-card>
        <v-card-text>
          High Score : <h4>{{ score }}</h4> <br>
          Ingredients Measure:
          <v-list-item
            v-for="(item, index) in ingList"
            :key="index"
          >{{index}} : {{item}}</v-list-item>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" block @click="dialog = false">Close Dialog</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  data: () => ({
    show: false,
    dialog: false,
    score: 0,
    ingList: [],
    calorieVal: 0,
    ingredients: [
      {'name' : '', 'capacity' : '', 'durability' : '', 'flavor' : '', 'texture' : '', 'calories' : ''},
      {'name' : '', 'capacity' : '', 'durability' : '', 'flavor' : '', 'texture' : '', 'calories' : ''}]
  }),
  methods: {
    async getHighestScore(checkCalorie=false) {
      fetch('http://localhost:8000/api/v1/getHighScore', {
        method: 'POST',
        body: checkCalorie ? JSON.stringify({Ingredients : this.ingredients, calorieCheck: this.calorieVal}) : JSON.stringify({Ingredients : this.ingredients})
      }).then((response) => response.json())
      .then(data => {
        this.score = data.Score;
        this.ingList = data.finalCounts
        this.dialog = true
      })
    },
    addIngredient() {
      this.ingredients.push({'name' : '', 'capacity' : '', 'durability' : '', 'flavor' : '', 'texture' : '', 'calories' : ''})
    },
  },
}
</script>
