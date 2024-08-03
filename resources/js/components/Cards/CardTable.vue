<template>
  <div
    class="relative flex flex-col w-full min-w-0 mb-6 break-words rounded shadow-lg"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']"
  >
    <div class="px-4 py-3 mb-0 border-0 rounded-t">
      <div class="flex flex-wrap items-center">
        <div class="relative flex-1 flex-grow w-full max-w-full px-4">
          <h3
            class="text-lg font-semibold"
            :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']"
          >
            Card Tables
          </h3>
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <!-- Projects table -->
      <table class="items-center w-full bg-transparent border-collapse">
        <thead>
          <tr>
            <th
              class="px-6 py-3 text-xs font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid whitespace-nowrap"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Project
            </th>
            <th
              class="px-6 py-3 text-xs font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid whitespace-nowrap"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Budget
            </th>
            <th
              class="px-6 py-3 text-xs font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid whitespace-nowrap"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Status
            </th>
            <th
              class="px-6 py-3 text-xs font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid whitespace-nowrap"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Users
            </th>
            <th
              class="px-6 py-3 text-xs font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid whitespace-nowrap"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            >
              Completion
            </th>
            <th
              class="px-6 py-3 text-xs font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid whitespace-nowrap"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
              ]"
            ></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th
              class="flex items-center p-4 px-6 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <img
                :src="bootstrap"
                class="w-12 h-12 bg-white border rounded-full"
                alt="..."
              />
              <span
                class="ml-3 font-bold"
                :class="[
                  color === 'light' ? 'text-blueGray-600' : 'text-white',
                ]"
              >
                Argon Design System
              </span>
            </th>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              $2,500 USD
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <i class="mr-2 text-orange-500 fas fa-circle"></i> pending
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex">
                <img
                  :src="team1"
                  alt="..."
                  class="w-10 h-10 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team2"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team3"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team4"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex items-center">
                <span class="mr-2">60%</span>
                <div class="relative w-full">
                  <div
                    class="flex h-2 overflow-hidden text-xs bg-red-200 rounded"
                  >
                    <div
                      style="width: 60%;"
                      class="flex flex-col justify-center text-center text-white bg-red-500 shadow-none whitespace-nowrap"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs text-right align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <table-dropdown />
            </td>
          </tr>
          <tr>
            <th
              class="flex items-center p-4 px-6 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <img
                :src="angular"
                class="w-12 h-12 bg-white border rounded-full"
                alt="..."
              />
              <span
                class="ml-3 font-bold"
                :class="[
                  color === 'light' ? 'text-blueGray-600' : 'text-white',
                ]"
              >
                Angular Now UI Kit PRO
              </span>
            </th>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              $1,800 USD
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <i class="mr-2 fas fa-circle text-emerald-500"></i>
              completed
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex">
                <img
                  :src="team1"
                  alt="..."
                  class="w-10 h-10 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team2"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team3"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team4"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex items-center">
                <span class="mr-2">100%</span>
                <div class="relative w-full">
                  <div
                    class="flex h-2 overflow-hidden text-xs rounded bg-emerald-200"
                  >
                    <div
                      style="width: 100%;"
                      class="flex flex-col justify-center text-center text-white shadow-none whitespace-nowrap bg-emerald-500"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs text-right align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <table-dropdown />
            </td>
          </tr>
          <tr>
            <th
              class="flex items-center p-4 px-6 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <img
                :src="sketch"
                class="w-12 h-12 bg-white border rounded-full"
                alt="..."
              />
              <span
                class="ml-3 font-bold"
                :class="[
                  color === 'light' ? 'text-blueGray-600' : 'text-white',
                ]"
              >
                Black Dashboard Sketch
              </span>
            </th>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              $3,150 USD
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <i class="mr-2 text-red-500 fas fa-circle"></i> delayed
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex">
                <img
                  :src="team1"
                  alt="..."
                  class="w-10 h-10 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team2"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team3"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team4"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex items-center">
                <span class="mr-2">73%</span>
                <div class="relative w-full">
                  <div
                    class="flex h-2 overflow-hidden text-xs bg-red-200 rounded"
                  >
                    <div
                      style="width: 73%;"
                      class="flex flex-col justify-center text-center text-white bg-red-500 shadow-none whitespace-nowrap"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs text-right align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <table-dropdown />
            </td>
          </tr>
          <tr>
            <th
              class="flex items-center p-4 px-6 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <img
                :src="react"
                class="w-12 h-12 bg-white border rounded-full"
                alt="..."
              />
              <span
                class="ml-3 font-bold"
                :class="[
                  color === 'light' ? 'text-blueGray-600' : 'text-white',
                ]"
              >
                React Material Dashboard
              </span>
            </th>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              $4,400 USD
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <i class="mr-2 text-teal-500 fas fa-circle"></i> on schedule
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex">
                <img
                  :src="team1"
                  alt="..."
                  class="w-10 h-10 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team2"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team3"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team4"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex items-center">
                <span class="mr-2">90%</span>
                <div class="relative w-full">
                  <div
                    class="flex h-2 overflow-hidden text-xs bg-teal-200 rounded"
                  >
                    <div
                      style="width: 90%;"
                      class="flex flex-col justify-center text-center text-white bg-teal-500 shadow-none whitespace-nowrap"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs text-right align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <table-dropdown />
            </td>
          </tr>
          <tr>
            <th
              class="flex items-center p-4 px-6 text-xs text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <img
                :src="vue"
                class="w-12 h-12 bg-white border rounded-full"
                alt="..."
              />
              <span
                class="ml-3 font-bold"
                :class="[
                  color === 'light' ? 'text-blueGray-600' : 'text-white',
                ]"
              >
                React Material Dashboard
              </span>
            </th>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              $2,200 USD
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <i class="mr-2 fas fa-circle text-emerald-500"></i>
              completed
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex">
                <img
                  :src="team1"
                  alt="..."
                  class="w-10 h-10 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team2"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team3"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
                <img
                  :src="team4"
                  alt="..."
                  class="w-10 h-10 -ml-4 border-2 rounded-full shadow border-blueGray-50"
                />
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <div class="flex items-center">
                <span class="mr-2">100%</span>
                <div class="relative w-full">
                  <div
                    class="flex h-2 overflow-hidden text-xs rounded bg-emerald-200"
                  >
                    <div
                      style="width: 100%;"
                      class="flex flex-col justify-center text-center text-white shadow-none whitespace-nowrap bg-emerald-500"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
            <td
              class="p-4 px-6 text-xs text-right align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap"
            >
              <table-dropdown />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import TableDropdown from "@/components/Dropdowns/TableDropdown.vue";

import bootstrap from "../../../assets/img/bootstrap.jpg";
import angular from "../../../assets/img/angular.jpg";
import sketch from "../../../assets/img/sketch.jpg";
import react from "../../../assets/img/react.jpg";
import vue from "../../../assets/img/react.jpg";

import team1 from "../../../assets/img/team-1-800x800.jpg";
import team2 from "../../../assets/img/team-2-800x800.jpg";
import team3 from "../../../assets/img/team-3-800x800.jpg";
import team4 from "../../../assets/img/team-4-470x470.png";

export default {
  data() {
    return {
      bootstrap,
      angular,
      sketch,
      react,
      vue,
      team1,
      team2,
      team3,
      team4,
    };
  },
  components: {
    TableDropdown,
  },
  props: {
    color: {
      default: "light",
      validator: function (value) {
        // The value must match one of these strings
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
  },
};
</script>
