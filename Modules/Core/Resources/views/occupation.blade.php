<validation-provider v-slot="{ errors }" name="Pekerjaan" :rules="occupationRules">
	<v-autocomplete
		:items="items"
		item-text="name"
		clearable
		:class="occupationClass"
		v-model="occupation"
		:name="occupationInputName"
		:label="occupationLabel"
		:error-messages="errors"
		:disabled="disabled">
	</v-autocomplete>
</validation-provider>