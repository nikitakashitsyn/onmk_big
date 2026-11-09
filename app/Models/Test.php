<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Test
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $group_id
 * @property array|null $data
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Test whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Test extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'type',
        'group_id',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];


    const TYPE_CHOICE = 'choice';
    const TYPE_INPUT = 'input';
    const TYPE_TABLES_SCHULTE = 'tables_schulte';

    const TYPES = [
        self::TYPE_CHOICE => 'Простой выбор',
        self::TYPE_INPUT => 'Ответ в виде текста',
        self::TYPE_TABLES_SCHULTE => 'Таблицы Шульте'
    ];


    public function type()
    {
        return self::TYPES[$this->type] ?? null;
    }

    public function questionAudioPath()
    {
        return 'tts/' . $this->id . '/' . md5($this->data['question']['text']) . '.ogg';

    }

    public function getQuestionAudioUrl()
    {
        $path = $this->questionAudioPath();
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }
    }

    public function updateQuestionTts()
    {
        $path = $this->questionAudioPath();

        if (!Storage::disk('public')->exists($path)) {

            $result = false;
            $url = "https://tts.api.cloud.yandex.net/speech/v1/tts:synthesize";

            //dd((strip_tags($this->data['question']['text'])));
            $post = "text=" . (strip_tags($this->data['question']['text'])) . "&lang=ru-RU";
            $headers = ['Authorization: Api-Key ' . env('SPEECHKIT_API_KEY')];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, false);
            if ($post !== false) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            if (curl_errno($ch)) {

            }
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {

            } else {
                Storage::disk('public')->put($path, $response);
                $result = true;
            }
            curl_close($ch);
            return $result;
        }
    }

}
