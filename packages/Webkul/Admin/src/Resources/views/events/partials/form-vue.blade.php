@php
    $eventsStorageBase = rtrim(asset('storage'), '/');
    $relatedEventsTreeUrl = $relatedEventsTreeUrl ?? route('admin.events.related-tree');
@endphp

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-event-fields-template"
    >
        <div class="flex flex-col gap-4">
            <input
                type="hidden"
                name="event_custom_fields_form"
                value="1"
            >

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 pb-4 dark:border-gray-700">
                <p class="min-w-0 flex-1 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('admin::app.events.create.custom-fields.title')
                </p>

                <div
                    class="secondary-button shrink-0 text-sm"
                    v-on:click="addField"
                >
                    @lang('admin::app.events.create.custom-fields.add-field')
                </div>
            </div>

            <div
                v-if="fields.length"
                class="block w-full overflow-x-auto rounded-lg border border-gray-200 bg-gray-50/80 shadow-sm dark:border-gray-700 dark:bg-gray-950/50"
            >
                <x-admin::table class="!min-w-[720px] !border-0">
                    <x-admin::table.thead class="text-sm font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-100">
                        <x-admin::table.thead.tr>
                            <x-admin::table.th class="!py-3 text-gray-700 dark:text-gray-100">
                                @lang('admin::app.events.create.custom-fields.field-name')
                            </x-admin::table.th>

                            <x-admin::table.th class="!py-3 text-gray-700 dark:text-gray-100">
                                @lang('admin::app.events.create.custom-fields.field-type')
                            </x-admin::table.th>

                            <x-admin::table.th class="!py-3 text-gray-700 dark:text-gray-100">
                                @lang('admin::app.events.create.custom-fields.field-value')
                            </x-admin::table.th>

                            <x-admin::table.th class="!py-3 text-right text-gray-700 dark:text-gray-100">
                                @lang('admin::app.leads.common.products.action')
                            </x-admin::table.th>
                        </x-admin::table.thead.tr>
                    </x-admin::table.thead>

                    <x-admin::table.tbody>
                        <x-admin::table.thead.tr
                            class="border-b border-gray-100 bg-white text-gray-800 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-950/80"
                            v-for="(field, idx) in fields"
                            v-bind:key="idx"
                        >
                            <x-admin::table.td class="!align-top !py-4">
                                <x-admin::form.control-group class="!mb-0">
                                    <x-admin::form.control-group.label class="required text-gray-800 dark:text-gray-100">
                                        @lang('admin::app.events.create.custom-fields.field-name')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        ::name="'fields[' + idx + '][name]'"
                                        rules="required"
                                        label="{{ __('admin::app.events.create.custom-fields.field-name') }}"
                                        placeholder="{{ __('admin::app.events.create.custom-fields.placeholder-name') }}"
                                        ::value="field.name"
                                    />

                                    <x-admin::form.control-group.error ::name="'fields[' + idx + '][name]'" />
                                </x-admin::form.control-group>
                            </x-admin::table.td>

                            <x-admin::table.td class="!align-top !py-4">
                                <x-admin::form.control-group class="!mb-0">
                                    <x-admin::form.control-group.label class="required text-gray-800 dark:text-gray-100">
                                        @lang('admin::app.events.create.custom-fields.field-type')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="select"
                                        class="cursor-pointer min-w-[11rem] !bg-white !text-gray-900 dark:!bg-gray-900 dark:!text-gray-100"
                                        ::name="'fields[' + idx + '][type]'"
                                        rules="required"
                                        label="{{ __('admin::app.events.create.custom-fields.field-type') }}"
                                        v-model="field.type"
                                        v-on:change="onFieldTypeChange(field)"
                                    >
                                        <option
                                            class="bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
                                            value="text"
                                        >
                                            @lang('admin::app.events.create.custom-fields.type-text')
                                        </option>

                                        <option
                                            class="bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
                                            value="textarea"
                                        >
                                            @lang('admin::app.events.create.custom-fields.type-textarea')
                                        </option>

                                        <option
                                            class="bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
                                            value="number"
                                        >
                                            @lang('admin::app.events.create.custom-fields.type-number')
                                        </option>

                                        <option
                                            class="bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
                                            value="date"
                                        >
                                            @lang('admin::app.events.create.custom-fields.type-date')
                                        </option>

                                        <option
                                            class="bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
                                            value="time"
                                        >
                                            @lang('admin::app.events.create.custom-fields.type-time')
                                        </option>

                                        <option
                                            class="bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-100"
                                            value="image"
                                        >
                                            @lang('admin::app.events.create.custom-fields.type-image')
                                        </option>
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error ::name="'fields[' + idx + '][type]'" />
                                </x-admin::form.control-group>
                            </x-admin::table.td>

                            <x-admin::table.td class="!align-top !py-4">
                                <x-admin::form.control-group class="!mb-0">
                                    <x-admin::form.control-group.label class="text-gray-800 dark:text-gray-100">
                                        @lang('admin::app.events.create.custom-fields.field-value')
                                    </x-admin::form.control-group.label>

                                    <div v-bind:key="'event-field-val-' + idx + '-' + field.type">
                                    <template v-if="field.type === 'textarea'">
                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-textarea'"
                                            type="textarea"
                                            ::name="'fields[' + idx + '][value]'"
                                            label="{{ __('admin::app.events.create.custom-fields.field-value') }}"
                                            placeholder="{{ __('admin::app.events.create.custom-fields.placeholder-value') }}"
                                            ::value="field.value"
                                        />

                                        <x-admin::form.control-group.error ::name="'fields[' + idx + '][value]'" />
                                    </template>

                                    <template v-else-if="field.type === 'image'">
                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-old'"
                                            type="hidden"
                                            ::name="'fields[' + idx + '][old_value]'"
                                            ::value="field.value"
                                        />

                                        <div
                                            v-if="field.value"
                                            v-bind:key="'val-' + idx + '-link'"
                                            class="mb-2"
                                        >
                                            <a
                                                v-bind:href="currentFileUrl(field.value)"
                                                target="_blank"
                                                class="text-xs font-medium text-brandColor hover:underline"
                                            >
                                                @lang('admin::app.events.create.custom-fields.view-current-file')
                                            </a>
                                        </div>

                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-file'"
                                            type="file"
                                            ::name="'fields[' + idx + '][value]'"
                                            label="{{ __('admin::app.events.create.custom-fields.field-value') }}"
                                        />

                                        <x-admin::form.control-group.error ::name="'fields[' + idx + '][value]'" />
                                    </template>

                                    <template v-else-if="field.type === 'text'">
                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-text'"
                                            type="text"
                                            ::name="'fields[' + idx + '][value]'"
                                            label="{{ __('admin::app.events.create.custom-fields.field-value') }}"
                                            placeholder="{{ __('admin::app.events.create.custom-fields.placeholder-value') }}"
                                            ::value="field.value"
                                        />

                                        <x-admin::form.control-group.error ::name="'fields[' + idx + '][value]'" />
                                    </template>

                                    <template v-else-if="field.type === 'number'">
                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-number'"
                                            type="number"
                                            ::name="'fields[' + idx + '][value]'"
                                            label="{{ __('admin::app.events.create.custom-fields.field-value') }}"
                                            placeholder="{{ __('admin::app.events.create.custom-fields.placeholder-value') }}"
                                            ::value="field.value"
                                        />

                                        <x-admin::form.control-group.error ::name="'fields[' + idx + '][value]'" />
                                    </template>

                                    <template v-else-if="field.type === 'date'">
                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-date'"
                                            type="date"
                                            ::name="'fields[' + idx + '][value]'"
                                            label="{{ __('admin::app.events.create.custom-fields.field-value') }}"
                                            ::value="field.value"
                                        />

                                        <x-admin::form.control-group.error ::name="'fields[' + idx + '][value]'" />
                                    </template>

                                    <template v-else-if="field.type === 'time'">
                                        <x-admin::form.control-group.control
                                            v-bind:key="'val-' + idx + '-time'"
                                            type="time"
                                            ::name="'fields[' + idx + '][value]'"
                                            label="{{ __('admin::app.events.create.custom-fields.field-value') }}"
                                            ::value="field.value"
                                        />

                                        <x-admin::form.control-group.error ::name="'fields[' + idx + '][value]'" />
                                    </template>
                                    </div>
                                </x-admin::form.control-group>
                            </x-admin::table.td>

                            <x-admin::table.td class="!align-top !px-4 !py-4 text-right">
                                <span
                                    class="icon-delete inline-flex cursor-pointer rounded-md p-1.5 text-2xl text-gray-600 transition-all hover:bg-gray-200 hover:text-red-600 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-red-400 max-sm:place-self-center"
                                    v-on:click="removeField(idx)"
                                >
                                </span>
                            </x-admin::table.td>
                        </x-admin::table.thead.tr>
                    </x-admin::table.tbody>
                </x-admin::table>
            </div>

            <div
                v-else
                class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-10 text-center text-sm text-gray-500 dark:border-gray-600 dark:bg-gray-900/40 dark:text-gray-400"
            >
                @lang('admin::app.events.create.custom-fields.empty')
            </div>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-related-events-template"
    >
        <div class="flex flex-col gap-4">
            <div>
                <p class="text-base font-semibold text-gray-800 dark:text-white">
                    @lang('admin::app.events.create.related-events.title')
                </p>

                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    @lang('admin::app.events.create.related-events.tree-hint')
                </p>
            </div>

            <template v-if="isLoading">
                <x-admin::shimmer.tree />
            </template>

            <template v-else>
                <div
                    v-if="flatRows.length"
                    class="max-h-96 overflow-y-auto rounded-lg border border-gray-200 bg-gray-50/50 p-2 dark:border-gray-700 dark:bg-gray-950/30"
                >
                    <template
                        v-for="(row, rowIdx) in flatRows"
                        v-bind:key="row.kind === 'event' ? 'e-' + row.id + '-' + rowIdx : 'c-' + rowIdx + '-' + row.indent"
                    >
                        <div
                            v-if="row.kind === 'category'"
                            class="select-none border-t border-gray-200 py-2 text-sm font-semibold text-gray-800 first:border-t-0 dark:border-gray-700 dark:text-white"
                            v-bind:style="{ paddingLeft: (row.indent * 14) + 'px' }"
                        >
                            @{{ row.name }}
                        </div>

                        <label
                            v-else
                            class="flex cursor-pointer items-center gap-2.5 rounded-md py-1.5 text-sm text-gray-700 hover:bg-white/80 dark:text-gray-300 dark:hover:bg-gray-900/50"
                            v-bind:style="{ paddingLeft: (row.indent * 14) + 'px' }"
                        >
                            <input
                                type="checkbox"
                                class="peer hidden"
                                v-bind:checked="isSelected(row.id)"
                                v-on:change="toggleEvent(row.id)"
                            />

                            <span class="icon-checkbox-outline peer-checked:icon-checkbox-select shrink-0 cursor-pointer rounded-md text-xl text-gray-600 peer-checked:text-brandColor dark:text-gray-400">
                            </span>

                            <span class="min-w-0 flex-1">
                                @{{ row.title }}
                            </span>
                        </label>
                    </template>
                </div>

                <div
                    v-else
                    class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                >
                    @lang('admin::app.events.create.related-events.empty-tree')
                </div>

                <template
                    v-for="id in selectedIdsSorted"
                    v-bind:key="'rel-h-' + id"
                >
                    <input
                        type="hidden"
                        name="related_events[]"
                        v-bind:value="id"
                    />
                </template>

                <p
                    v-if="selectedIds.length === 0 && flatRows.length"
                    class="mt-2 text-xs text-gray-500 dark:text-gray-400"
                >
                    @lang('admin::app.events.create.related-events.empty')
                </p>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-event-fields', {
            template: '#v-event-fields-template',

            props: ['dataData'],

            data() {
                return {
                    fields: this.dataData ? this.dataData : [],
                };
            },

            methods: {
                addField() {
                    this.fields.push({
                        name: '',
                        type: 'text',
                        value: '',
                    });
                },

                onFieldTypeChange(field) {
                    field.value = '';
                },

                removeField(rowIndex) {
                    this.fields.splice(rowIndex, 1);
                },

                currentFileUrl(path) {
                    const base = @json($eventsStorageBase);
                    const p = (path || '').replace(/^\//, '');

                    return p ? base + '/' + p : base;
                },
            },
        });

        app.component('v-related-events', {
            template: '#v-related-events-template',

            props: {
                dataData: {
                    type: Array,
                    default: () => [],
                },
            },

            data() {
                return {
                    isLoading: true,
                    flatRows: [],
                    selectedIds: [],
                };
            },

            computed: {
                selectedIdsSorted() {
                    return [...this.selectedIds].sort((a, b) => a - b);
                },
            },

            created() {
                this.syncSelectedFromProp();
            },

            watch: {
                dataData: {
                    deep: true,
                    handler() {
                        this.syncSelectedFromProp();
                    },
                },
            },

            mounted() {
                this.loadTree();
            },

            methods: {
                syncSelectedFromProp() {
                    const src = Array.isArray(this.dataData) ? this.dataData : [];

                    this.selectedIds = src
                        .map((e) => Number(e && e.id))
                        .filter((id) => id > 0);
                },

                loadTree() {
                    axios
                        .get(@json($relatedEventsTreeUrl))
                        .then((response) => {
                            this.isLoading = false;
                            this.flatRows = response.data.data || [];
                        })
                        .catch(() => {
                            this.isLoading = false;
                            this.flatRows = [];
                        });
                },

                isSelected(id) {
                    return this.selectedIds.includes(id);
                },

                toggleEvent(id) {
                    const idx = this.selectedIds.indexOf(id);

                    if (idx === -1) {
                        this.selectedIds.push(id);
                    } else {
                        this.selectedIds.splice(idx, 1);
                    }
                },
            },
        });
    </script>
@endPushOnce
