<script setup>
import Api from './api.js'
import {ref, onBeforeMount} from "vue";

const weekDays = {
  Monday: 1,
  Tuesday: 2,
  Wednesday: 4,
  Thursday: 8,
  Friday: 16,
  Saturday: 32,
  Sunday: 64,
};

/**
 * @type{Ref<UnwrapRef<int>>}
 */
let selectedWeekDays = ref(0);

/**
 * @type {Ref<UnwrapRef<null|boolean>>}
 */
let partiallyWork = ref(null);

/**
 * @type {Ref<UnwrapRef<Object|null>>}
 */
let languages = ref(null);

/**
 *
 * @type {Ref<UnwrapRef<number[]>>}
 */
let selectedLanguageIds = ref([]);

/**
 * @type {Ref<UnwrapRef<Object|null>>}
 */
let employees = ref(null);

/**
 * @param {number} weekDay
 */
function enableWeekDay(weekDay)
{
  if (!checkWeekDay(weekDay)) {
    selectedWeekDays.value |= weekDay;
    updateEmployees();
  }
}

/**
 * @param {number} weekDay
 */
function disableWeekDay(weekDay)
{
  if ((selectedWeekDays.value & weekDay) === weekDay) {
    selectedWeekDays.value -= weekDay;
    updateEmployees();
  }
}

/**
 * @param {number} weekDay
 * @return {boolean}
 */
function checkWeekDay(weekDay)
{
  return (selectedWeekDays.value & weekDay) === weekDay;
}

/**
 * @param {null|boolean} partiallyWorkEnabled
 */
function setPartiallyWork(partiallyWorkEnabled)
{
  if (partiallyWork.value !== partiallyWorkEnabled) {
    partiallyWork.value = partiallyWorkEnabled;
    updateEmployees();
  }
}

onBeforeMount(async () => {
  if (languages.value === null) {
    languages.value = await Api.getInstance().getLanguages();
  }

  if (employees.value === null) {
    updateEmployees();
  }
})

function selectLanguage(languageId)
{
  if (!isLanguageSelected(languageId)) {
    selectedLanguageIds.value.push(languageId);
    updateEmployees();
  }
}

function deselectLanguage(languageId)
{
  const index = selectedLanguageIds.value.indexOf(languageId);
  if (index > -1) {
    selectedLanguageIds.value.splice(index, 1);
    updateEmployees();
  }
}

function isLanguageSelected(languageId)
{
  return selectedLanguageIds.value.indexOf(languageId) > -1;
}

async function updateEmployees()
{
  employees.value = null;
  employees.value = await Api.getInstance().getEmployees(
      selectedWeekDays.value,
      partiallyWork.value,
      selectedLanguageIds.value,
  );
}

</script>

<template>
  <div class="container">
    <div class="card mb-1">
      <div class="card-body">
        <template v-if="languages === null">
          Loading languages
        </template>
        <template v-else>
          <div class="mb-1">
            <b>Week days:</b><br>
            <template v-for="(weekDay, weekDayName) in weekDays">
              <template v-if="checkWeekDay(weekDay)">
            <span class="btn btn-success m-1" v-on:click="disableWeekDay(weekDay)">
              {{ weekDayName }}
            </span>
              </template>
              <template v-else>
            <span class="btn btn-primary m-1" v-on:click="enableWeekDay(weekDay)">
              {{ weekDayName }}
            </span>
              </template>
            </template>
          </div>
          <div class="mb-1">
            <b>Partially:</b><br>
            <span class="btn m-1" :class="(partiallyWork === null ? 'btn-success' : 'btn-primary')"
                  v-on:click="setPartiallyWork(null)">
              Not important
            </span>
            <span class="btn m-1" :class="(partiallyWork === true ? 'btn-success' : 'btn-primary')"
                  v-on:click="setPartiallyWork(true)">
              Partially
            </span>
            <span class="btn m-1" :class="(partiallyWork === false ? 'btn-success' : 'btn-primary')"
                  v-on:click="setPartiallyWork(false)">
              Not partially
            </span>
          </div>
          <div>
            <b>Languages:</b><br>
            <template v-for="language in languages">
              <template v-if="isLanguageSelected(language['id'])">
                <span class="btn m-1 btn-success" v-on:click="deselectLanguage(language['id'])">
                  {{ language['name_ru'] }}
                </span>
              </template>
              <template v-else>
                <span class="btn m-1 btn-primary" v-on:click="selectLanguage(language['id'])">
                  {{ language['name_ru'] }}
                </span>
              </template>

            </template>
          </div>
        </template>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <template v-if="employees === null">
          Loading employees
        </template>
        <template v-else>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Middle name</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="employee in employees">
                <th scope="row">{{ employee['id'] }}</th>
                <td>{{ employee['first_name'] }}</td>
                <td>{{ employee['last_name'] }}</td>
                <td>{{ employee['middle_name'] }}</td>
              </tr>
            </tbody>
          </table>
        </template>
      </div>
    </div>
  </div>
</template>

