<template>
    <div class="flex dropdown" :class="{'open' : open}">
        <input type="text" v-model="numeroCivique" class="w-20 ml-1 bg-white border outline-none cursor-text focus:bg-white border-border form-input text-start"
        @keydown.enter="numeroCiviqueUpdated()"
        @change="numeroCiviqueUpdated()"
        >
        <input type="text" v-model="searchText" ref="searchInput" :placeholder="placeholder" class="flex-grow ml-1 bg-white border outline-none cursor-text focus:bg-white border-border form-input text-start"
        @input="searchChanged" 
        @keydown.down="down"
        @keydown.up="up"
        @keydown.enter="suggestionSelected(filteredItems[highlightIndex])"
        @keydown.esc="setOpen(false)"
        @blur="setOpen(false)"
        @click="setOpen(true)">
        <!-- v-if="filteredItems.length!==0" -->
            <div class="absolute flex w-8/12 mt-8 ml-2 overflow-y-auto text-center md:w-1/4" >
                <ul class="z-50 block w-full p-0 m-0 text-center list-none suggestion-list bg-background">
                    <li class="px-10 py-2 text-center cursor-pointer hover:bg-tertiary" v-for="(item, index) in filteredItems" :key="item.id"
                        :class="{'bg-secondary' : index === highlightIndex}"
                        @mousedown.prevent
                        @click="suggestionSelected(item)">
                        {{ item[itemField] }}
                    </li>
                </ul>
            </div>  
    </div>
</template>

<script>
export default {
    props: {
        items: Array,
            default () {
                return []
        },
        itemField: {
            type: String,
            default: 'full_name'
        },
        initialItemValue: {
            type: String,
            default: ''
        },
        placeholder: {
            type: String,
            default: "Lang_get('site_lang.default_search')"
        },
        textNotFound: {
            type: String,
            default: "Lang_get('site_lang.name_not_found')"
        }
    },
    data () {
        return {
            searchText: '',
            open: false,
            highlightIndex: 0,
            lastSearchText: '',
            numeroCivique: ''
        }
    },
    mounted (){
        this.numeroCivique = '';
        let number = this.initialItemValue.replace(/\s.*/,'');
        let searchableText = /\d/.test(number) ? this.initialItemValue.replace(number+' ','') : this.initialItemValue;
        this.numeroCivique = /\d/.test(number) ? number + ' ' : '';
        this.searchText = searchableText;
    },
    watch: {
        initialItemValue(newData, oldData) {
            // this.searchText = newData;
            this.numeroCivique = '';
            let number = newData.replace(/\s.*/,'');
            let searchableText = /\d/.test(number) ? newData.replace(number+' ','') : newData;
            this.numeroCivique = /\d/.test(number) ? number + ' ' : '';
            this.searchText = searchableText;            
        },
    },
    computed: {
        filteredItems () {
            // Determine first if there is a numero civique
            // let number = this.searchText.replace(/\s.*/,'');
            // let searchableText = /\d/.test(number) ? this.searchText.replace(number+' ','') : this.searchText;
            let searchableText = this.searchText;
            // Filter
            var fileteredItemsArray = this.items;
            if(this.searchText) {
                fileteredItemsArray = this.items.filter((item) => {
                    var optionText = item[this.itemField].toUpperCase()
                    return optionText.match(searchableText.toUpperCase())
                });
            }
            if(fileteredItemsArray.length === 0) {
                var NotFoundOption = [];
                NotFoundOption.id = '';
                NotFoundOption[this.itemField] = this.textNotFound + ' - ' + this.searchText;
                fileteredItemsArray.push(NotFoundOption);
            }
            return fileteredItemsArray;
        }
    },
    methods: {
        setOpen(isOpen) {
            this.open = isOpen;
            if (this.open) {
                this.$refs.searchInput.focus();
                this.lastSearchText = this.searchText;
                this.searchText = '';
            }else if (this.searchText) {
                if (this.searchText.trim() === '') {
                    this.searchText = this.lastSearchText;
                }
            }
        },
        searchChanged() {
            if (!this.open) {
                this.open = true;
            }
            this.highlightIndex = 0;
        },
        suggestionSelected(item) {
            this.open = false;
            // Determine first if there is a numero civique
            // let number = this.searchText.replace(/\s.*/,'');
            // this.searchText = /\d/.test(number) ? number + ' ' + item[this.itemField] : item[this.itemField];
            this.searchText = item[this.itemField];
            this.$emit("new-selected-item", this.numeroCivique + this.searchText, item);
        },
        numeroCiviqueUpdated() {
            this.numeroCivique = (this.numeroCivique.trim() === '') ? '' : this.numeroCivique.trim() + ' ';
            this.$emit("new-selected-item", this.numeroCivique + this.searchText, null);
        },
        up() {
            if (this.open) {
                if (this.highlightIndex > 0) {
                    this.highlightIndex--;
                }
            } else {
                this.setOpen(true);
            }
        },
        down() {
            if (this.open) {
                if (this.highlightIndex < this.filteredItems.length - 1) {
                    this.highlightIndex++;
                }
            } else {
                this.setOpen(true);
            }
        }
    }
}
</script>

<style>
.suggestion-list {
  top: 36px;
}
.dropdown.open .suggestion-list {
  display: block;
}

.dropdown .suggestion-list {
  display: none;
}
</style>