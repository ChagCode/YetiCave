      <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
      <form class="form form--add-lot container form--invalid" action="add2.php" method="POST"
          enctype="multipart/form-data">
          <h2>Добавление лота</h2>
          <div class="form__container-two">

              <?php $classname = isset($errors['title']) ? "form__item--invalid" : ""; ?>
              <div class="form__item <?= $classname; ?>">
                  <label for="title">Наименование <sup>*</sup></label>
                  <input id="title" type="text" name="title" placeholder="Введите наименование лота"
                      value="<?= getPostVal('title'); ?>">
                  <span class="form__error"><?= $errors['title']; ?></span>
              </div>

              <?php $classname = isset($errors['category_id']) ? "form__item--invalid" : ""; ?>
              <div class="form__item <?= $classname; ?>">
                  <label for="category">Категория <sup>*</sup></label>
                  <select id="category" name="category">
                      <option>Выберите категорию</option>
                      <?php foreach ($categories as $category): ?>
                      <option value="<?= $category['id']; ?>"
                          <?php if ($category['id'] == getPostVal('category_id')): ?>selected<?php endif; ?>>
                          <?= $category['category']; ?></option>
                      <?php endforeach; ?>
                  </select>
                  <span class="form__error"><?= $errors['category_id']; ?></span>
              </div>
          </div>

          <?php $classname = isset($errors['lot_description']) ? "form__item--invalid" : ""; ?>
          <div class="form__item form__item--wide <?= $classname; ?>">
              <label for="lot_description">Описание <sup>*</sup></label>
              <textarea id="lot_description" name="lot_description"
                  placeholder="Напишите описание лота"><?= getPostVal('lot_description'); ?></textarea>
              <span class="form__error"><?= $errors['lot_description']; ?></span>
          </div>

          <?php $classname = isset($errors['img']) ? "form__item--invalid" : ""; ?>
          <div class="form__item form__item--file <?= $classname; ?>">
              <label>Изображение <sup>*</sup></label>
              <div class="form__input-file">
                  <input class="visually-hidden" type="file" name="img" id="img" value="">
                  <label for="img">
                      Добавить
                  </label>
                  <span class="form__error"><?= $errors['img']; ?></span>
              </div>

          </div>

          <div class="form__container-three">
              <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : ""; ?>
              <div class="form__item form__item--small <?= $classname; ?>">
                  <label for="start_price">Начальная цена <sup>*</sup></label>
                  <input id="start_price" type="text" name="start_price" placeholder="0"
                      value="<?= getPostVal('start_price'); ?>">
                  <span class="form__error"><?= $errors['start_price']; ?></span>
              </div>

              <?php $classname = isset($errors['step']) ? "form__item--invalid" : ""; ?>
              <div class="form__item form__item--small <?= $classname; ?>">
                  <label for="step">Шаг ставки <sup>*</sup></label>
                  <input id="step" type="text" name="step" placeholder="0" value="<?= getPostVal('step'); ?>">
                  <span class="form__error"><?= $errors['step']; ?></span>
              </div>

              <?php $classname = isset($errors['date_finish']) ? "form__item--invalid" : ""; ?>
              <div class="form__item <?= $classname; ?>">
                  <label for="date_finish">Дата окончания торгов <sup>*</sup></label>
                  <input class="form__input-date" id="date_finish" type="text" name="date_finish"
                      placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= getPostVal('date_finish'); ?>">
                  <span class="form__error"><?= $errors['date_finish']; ?></span>
              </div>
          </div>

          <?php if (isset($errors)): ?>
          <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
          <?php endif; ?>
          <button type="submit" class="button">Добавить лот</button>
      </form>
