<form class="form-filter">

    <div class="form-filter__status no-border">

        <div class="status-title">
            Вид спорту
        </div>

        @foreach ($type_sports as $item)
            <div class="broad-status">
                <input type="checkbox"
                       id="sport-{{ $item->id }}"
                       name="sport-{{ $item->id }}"
                       value="{{ $item->id }}"
                       {{ $item->isChecked ? 'checked' : null }}
                class="checkbox-btn">

                <label for="sport-{{ $item->id }}" class="is-checkbox">{{ $item->name_kind_sport }}</label>
            </div>
        @endforeach
    </div>
    <div class="form-filter__status no-border">
        <div class="title-sort">Сортування</div>
        <select name="sort" class="sort-items-form">
            <option value="new-items"
                {{ Request::query('sort') == 'new-items' ? 'selected' : null }}
            >спочатку нові</option>

            <option value="old-items"
                {{ Request::query('sort') == 'old-items' ? 'selected' : null }}
            >спочатку старі</option>

            <option value="alphabet-start"
            {{ Request::query('sort') == 'alphabet-start' ? 'selected' : null }}
            >за алфавітом а-я</option>

            <option value="alphabet-end"
                {{ Request::query('sort') == 'alphabet-end' ? 'selected' : null }}
            >за алфавітом я-а</option>
        </select>
    </div>


    <div class="form-filter__status no-border">
        <div class="update-filter">
            <button class="btn no-border filter-btn">Оновити</button>
            </div>
    </div>
</form>
