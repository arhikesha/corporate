<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ArticalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->canDo('ADD_ARTICLES');

        ///Если false то будет foridden
    }

    //переопределение метода чтобы использовать $validator
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance(); // TODO: Change the autogenerated stub

        $validator->sometimes('alias','unique:articles|max:255',function($input){
            ////Проверяет присутсвует параметр в текущем маршуте
            if($this->route()->hasParameter('article')) {
                $model = $this->route()->parameter('article');////получаем текущую модель Article
               // dd($model);
                //dd($input->alias);
                return ($model->alias !== $input->alias) && !empty($input->alias);///Вернет false-- И данная валицация не будет исползоватся
                //$input->alias -содержания значения в тукущем inpute (dd($input->alias)

            }

            return !empty($input->alias);
        });
        
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            //
            'title'=>'required|max:255',
            'text'=>'required',
            'category_id'=>'required|integer',
            //'image'=>'required',

        ];
    }
}