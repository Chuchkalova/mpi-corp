<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogs extends MY_Table
{
    protected $table = 'catalogs';
    protected $table_top = 'catalogs_group';
    protected $controller = "catalogs";

    public function delete_from_group($group_id, $item_id)
    {
        $this->load->model("catalogs_extra_group_model");
        $this->catalogs_extra_group_model->delete_where(array('group_id' => $group_id, 'item_id' => $item_id,));
        redirect("catalogs/edit/$item_id");
    }

    public function delete_subitem($item_id)
    {
        $element = $this->catalogs_model->get_by_id($item_id);
        $this->catalogs_model->delete($item_id);
        redirect("catalog/edit/{$element['item_parent']}");
    }

    public function edit_subitem($pid = 0)
    {
        $this->edit_abstract($pid, "edit");
    }

    public function add_subitem($pid = 0)
    {
        $this->add_abstract($pid, "add");
    }

    public function get_add_buttons($pid = 0)
    {
        $extra = '';
        if (!$this->catalogs_group_model->get_count(array('is_block' => 0, 'pid' => $pid,))) {
            $extra = '<a href="' . site_url('/catalogs/csv/' . $pid . '/') . '" title="Выгрузить товары"><img src="/site_img/admin/csv.png"></a>';
        }
        return parent::get_add_buttons($pid) . $extra;
    }

    public function csv($pid)
    {
        $this->variant_model = null;
        if ($this->{$this->top_model}->check_variant($pid)) {
            $this->variant_model = $this->top_model;
        } else if ($this->{$this->model}->check_variant($pid)) {
            $this->variant_model = $this->model;
        }

        if (!$this->check_permissions('show')) {
            redirect('permission/');
            return;
        }

        $this->generate_template_top();

        $this->template->write_view('content', 'catalogs/csv', array(
            'pid' => $pid,
        ));

        $this->template->render();
    }

    private function write_log($message)
    {
        $log_file = $_SERVER['DOCUMENT_ROOT'] . '/logs/unloading/debug.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($log_file, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
    }

    public function csv_do($pid)
    {
        // Начало логирования процесса
        $this->write_log("Начало загрузки файла для группы ID: $pid");

        if ($this->catalogs_group_model->load_file_abstract("file", "/dir_images/", "upload.xlsx", "*", 0, 0, "", "fixed")) {
            $old_items = $this->catalogs_model->get_list(array('is_block' => 0, 'pid' => $pid), 'name', 'id');
            $group = $this->catalogs_group_model->get_by_id($pid);
            $types = array();

            if ($group['type_id'] > 0) {
                $this->write_log("Группа ID: {$group['id']} имеет type_id: {$group['type_id']}");

                $this->load->model('types_group_model');
                //$types_group=$this->types_group_model->get_by_fields(array('name'=>'Параметры','pid'=>$group['type_id'],));
                $types_group = $this->types_group_model->get_page(array('is_block'=>0,'pid'=>$group['type_id'],),null,null,'order');

                if (!empty($types_group)) {

                    $this->load->model('types_model');

                    $types = []; // Инициализируем пустой массив для хранения всех типов

                    foreach ($types_group as $myTypes_group) {
                        $this->write_log("Группа типов найдена для группы ID: {$group['id']}, ID группы типов: {$myTypes_group['id']}");

                        // Получаем список типов
                        $myTypes = $this->types_model->get_list(array('is_block' => 0, 'pid' => $myTypes_group['id']), 'name', 'id');

                        // Объединяем полученные массивы в общий массив
                        $types = array_merge($types, $myTypes);
                    }

                    if (empty($types)) {
                        $this->write_log("Типы не найдены для ID группы типов: {$types_group['id']}");
                    } else {
                        // Создаем массив с типами
                        $type_list = array_keys($types);

                        // Формируем строку с типами, разделенными переносом строки
                        $type_log = implode(PHP_EOL, $type_list);

                        // Записываем в лог
                        $this->write_log("Найденные типы:\n" . $type_log);
                    }
                } else {
                    $this->write_log("Группа типов не найдена для группы ID: {$group['id']}");
                }
            } else {
                $this->write_log("Группа ID: {$group['id']} не имеет type_id.");
            }

            $this->load->model('catalog_types_model');
            $exts = array('jpg', 'png', 'jpeg', 'gif');

            include($_SERVER['DOCUMENT_ROOT'] . "/application/backend/third_party/SimpleXLSX.php");
            if ($xlsx = Shuchkin\SimpleXLSX::parse($_SERVER['DOCUMENT_ROOT'] . '/dir_images/upload.xlsx')) {

                $this->write_log("Файл upload.xlsx успешно загружен и прочитан.");

                $rows = $xlsx->rows();
                $this->write_log("Количество строк в файле: " . count($rows));
                $types_translate = array();
                for ($i = 10; $i < count($rows[0]); ++$i) {
                    if (isset($types[$rows[0][$i]])) {
                        $types_translate[$i] = $types[$rows[0][$i]];
                    }
                }

                for ($i = 1; $i < count($rows); ++$i) {
                    // Логируем начало итерации
                    $this->write_log("Начало итерации: $i");

                    // Проверяем, есть ли значение в $rows[$i][0]
                    if (trim($rows[$i][0])) {
                        $this->write_log("Обнаружено значение в rows[$i][0]: " . $rows[$i][0]);

                        $new_item = array(
                            'name' => $rows[$i][0],
                            'short_text' => $rows[$i][2],
                            'text' => $rows[$i][3],
                            'price' => (int)$rows[$i][4],
                            'order' => (int)$rows[$i][5],
                            'h1' => $rows[$i][6],
                            'meta_title' => $rows[$i][7],
                            'meta_description' => $rows[$i][8],
                            'meta_keywords' => $rows[$i][9],
                        );

                        // Логируем данные для нового товара
                        $this->write_log("Данные для товара: " . print_r($new_item, true));

                        foreach ($new_item as $field => $value) {
                            if (!trim($value)) {
                                unset($new_item[$field]);
                                $this->write_log("Удалено поле '$field' из нового товара, так как оно пустое.");
                            }
                        }

                        foreach (array('text', 'short_text') as $field) {
                            if (isset($new_item[$field])) {
                                $new_item[$field] = "<p>" . str_replace("\n", '<br>', $new_item[$field]) . "</p>";
                                $this->write_log("Форматировано поле '$field' для товара: " . $new_item[$field]);
                            }
                        }

                        if (isset($old_items[$new_item['name']])) {
                            $item_id = $old_items[$new_item['name']];
                            $this->catalogs_model->update($item_id, $new_item);
                            $this->write_log("Обновлен товар ID: $item_id с именем: {$new_item['name']}");
                        } else {
                            $new_item['pid'] = $pid;
                            $new_item['url'] = $this->catalogs_model->build_unique_url('', $new_item['name']);
                            if ($item_id = $this->catalogs_model->insert($new_item)) {
                                $this->write_log("Добавлен новый товар ID: $item_id с именем: {$new_item['name']}");
                            } else {
                                $this->write_log("Ошибка при добавлении товара: " . print_r($new_item, true));
                            }
                            $this->write_log("Добавлен новый товар ID: $item_id с именем: {$new_item['name']}");
                        }

                        // Обработка типов товара
                        $sqls = array();
                        foreach ($types_translate as $index => $type_id) {
//                            if (isset($rows[$i][$index]) && (int)trim($rows[$i][$index]) == 1) {
//                                $sqls[] = "($item_id, $type_id)";
//                            }
                            $sqls[] = "($item_id, $type_id)";
                        }

                        // Массивы для хранения item_id и type_id
                        $itemIds = [];
                        $typeIds = [];

                        // Извлекаем item_id и type_id из строк
                        foreach ($sqls as $sql) {
                            // Убираем скобки и разбиваем строку на части
                            $sql = trim($sql, '()');
                            list($itemId, $typeId) = explode(',', $sql);

                            $itemIds[] = intval($itemId); // Приводим к целому числу
                            $typeIds[] = intval($typeId); // Приводим к целому числу
                        }

                        // Формируем строку для IN запроса
                        $itemIdsString = implode(',', array_map('intval', $itemIds));
                        $typeIdsString = implode(',', array_map('intval', $typeIds));

                        if (count($sqls)) {
                            $this->db->trans_start(); // Начинаем транзакцию

                            // SQL запрос для удаления дублирующих данных
                            $this->catalogs_model->sql_non_query('DELETE FROM catalog_types WHERE item_id IN ('.$itemIdsString.') AND type_id IN ('.$typeIdsString.')');

                            // Вставляем новые значения или обновляем существующие
                            $this->catalogs_model->sql_non_query('INSERT INTO `catalog_types` (`item_id`, `type_id`) VALUES ' . implode(',', $sqls) . ' ON DUPLICATE KEY UPDATE `type_id` = VALUES(`type_id`)');

                            $this->db->trans_complete(); // Завершаем транзакцию

                            // Проверяем, была ли транзакция успешной
                            if ($this->db->trans_status() === FALSE) {
                                // Обработка ошибки
                            } else {
                                // Запрос для получения текущих значений из catalog_types
                                $currentValues = $this->catalogs_model->sql_query_array('SELECT * FROM `catalog_types` WHERE `item_id` IN (30769)');

                                // Вывод текущих значений
//                                foreach ($currentValues as $row) {
//                                    echo 'Item ID: ' . $row['item_id'] . ', Type ID: ' . $row['type_id'] . '<br>';
//                                }
                            }
                            //echo 'DELETE FROM catalog_types WHERE item_id IN ('.$itemIdsString.') AND type_id IN ('.$typeIdsString.')</br>';
                            //echo 'INSERT INTO `catalog_types` (`item_id`, `type_id`) VALUES ' . implode(',', $sqls). ' ON DUPLICATE KEY UPDATE `type_id` = VALUES(`type_id`) ';
                            $this->write_log("Типы добавлены для товара ID: $item_id");
                        } else {
                            $this->write_log("Типы не добавлены для товара ID: $item_id, так как не найдено ни одного типа.");
                        }

                        // Обработка изображения
                        if (trim($rows[$i][1])) {
                            $filename = str_replace('https://mpi.ru.com', '', $rows[$i][1]);
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $filename)) {
                                foreach ($exts as $ext) {
                                    @unlink($_SERVER['DOCUMENT_ROOT'] . "/dir_images/catalogs_file1_{$item_id}_l.{$ext}");
                                    @unlink($_SERVER['DOCUMENT_ROOT'] . "/dir_images/50x50/catalogs_file1_{$item_id}_l.{$ext}");
                                }
                                $parts = explode('.', $filename);
                                $real_ext = strtolower(end($parts));
                                @copy(
                                    $_SERVER['DOCUMENT_ROOT'] . $filename,
                                    $_SERVER['DOCUMENT_ROOT'] . "/dir_images/catalogs_file1_{$item_id}_l.{$real_ext}"
                                );
                                $this->write_log("Файл изображения скопирован для товара ID: $item_id");
                            } else {
                                $this->write_log("Файл изображения не найден для товара ID: $item_id, путь: $filename");
                            }
                        } else {
                            $this->write_log("Изображение не указано для товара ID: $item_id");
                        }
                    } else {
                        $this->write_log("Нет значения в rows[$i][0], пропускаем итерацию.");
                    }
                }

            } else {
                $this->write_log("Ошибка при загрузке файла: upload.xlsx не может быть прочитан.");
            }
        } else {
            $this->write_log("Ошибка загрузки файла: upload.xlsx не был загружен.");
        }

        // Завершение логирования процесса
        $this->write_log("Загрузка файла завершена для группы ID: $pid");
        redirect("catalogs/show/$pid");
    }
}
