<div class="address-form">
	<validation-provider v-slot="{ errors }" name="Alamat" :rules="addressRules">
		<v-textarea
			:class="addressClass"
			v-model="address"
			:name="addressInputName"
    		:label="addessLabel"
    		auto-grow
			clearable
			rows="1"
	      	clear-icon="mdi-close"
    		:counter="addressCounter"
    		:error-messages="errors"
    		:disabled="disabled">
		</v-textarea>
	</validation-provider>
	<validation-provider v-slot="{ errors }" name="Nama Provinsi" :rules="provinceRules">
		<v-autocomplete
			:items="items"
			item-text="name"
			:class="provinceClass"
			v-model="province"
			:name="provinceInputName"
			:label="provinceLabel"
			:error-messages="errors"
			@change="refreshCity"
			:disabled="disabled">
		</v-autocomplete>
	</validation-provider>
	<validation-provider v-slot="{ errors }" name="Nama Kota" :rules="cityRules">
		<v-autocomplete
			:items="cityOptions"
			item-text="city"
			:class="cityClass"
			v-model="city"
			:name="cityInputName"
			:label="cityLabel"
			:error-messages="errors"
			:disabled="disabled">
		</v-autocomplete>
	</validation-provider>
</div>