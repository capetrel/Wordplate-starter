<?php


namespace App;

class FormBuilder
{

    /**
     * Context with errors in lik $context['errors']
     * @var array
     */
    private $context;

    public function __construct(array $context)
    {
        $this->context = $context;
    }

    /**
     * Generate html code for a field
     * @param string $key
     * @param string $name
     * @param $value
     * @param null|string $label
     * @param array $options
     * @param array $htmlAttributs
     * @return string
     */
    public function field(
        string $key,
        string $name,
        $value,
        ?string $label = null,
        array $options = [],
        array $htmlAttributs = []
    ): string {
        $type = $options['type'] ?? 'text';
        $error = $this->getErrorHtml($key);
        $value = $this->convertValue($value);
        $class = 'form-group';
        $attributes = array_merge([
            'class' => trim('form-control ' . ($options['class'] ?? '')),
            'name' => $name,
            'id' => $key,
        ], $htmlAttributs);

        if ($error) {
            $class .= ' has-danger';
            $attributes['class'] .= ' is-invalid';
        }
        if ($type === 'textarea') {
            $input = $this->textarea($value, $attributes);
        } elseif ($type === 'file') {
            $input = $this->file($attributes);
        } elseif ($type === 'checkbox') {
            $input = $this->checkbox($value, $attributes);
        } elseif (array_key_exists('options', $options)) {
            $input = $this->select($value, $options['options'], $attributes);
        } else {
            $attributes['type'] = $options['type'] ?? 'text';
            $input = $this->input($value, $attributes);
        }
        return "<p class=\"" . $class . "\"><label for=\"$key\">{$label}</label>{$input}{$error}</p>";
    }

    private function convertValue($value): string
    {
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }

    /**
     * Get errors in context (all variables passed to view) and generate html
     * @param $key
     * @return string
     */
    private function getErrorHtml($key)
    {
        $error = $this->context[$key] ?? false;
        if ($error) {
            return "<small class=\"form-text text-muted\">{$error}</small>";
        }
        return "";
    }

    /**
     * Generate html code for input type text
     * @param null|string $value
     * @param array $attributes
     * @return string
     */
    private function input(?string $value, array $attributes): string
    {
        return "<input " . $this->getHtmlFromArray($attributes) . " value=\"{$value}\">";
    }

    private function file(array $attributes): string
    {
        return "<input type=\"file\" " . $this->getHtmlFromArray($attributes) .">";
    }

    /**
     * Generate html code for input type textarea
     * @param null|string $value
     * @param array $attributes
     * @return string
     */
    private function textarea(?string $value, array $attributes): string
    {
        return "<textarea " . $this->getHtmlFromArray($attributes) . " rows=\"5\">{$value}</textarea>";
    }

    /**
     * Generate html select code
     * @param null|string $value
     * @param array $options
     * @param array $attributes
     * @return string
     */
    private function select(?string $value, array $options, array $attributes)
    {
        $htmlOptions = array_reduce(array_keys($options), function (string $html, string $key) use ($options, $value) {
            $params = ['value' => $key, 'selected' => $key === $value];
            $params = $this->getHtmlFromArray($params);
            return $html . "<option $params>$options[$key]</option>";
        }, "");
        return "<select " . $this->getHtmlFromArray($attributes) . ">$htmlOptions</select>";
    }

    /**
     * Generate the html code of the attributes from a array
     * @param array $attributes
     * @return string
     */
    private function getHtmlFromArray(array $attributes)
    {

        $htmlParts = [];
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $htmlParts[] = (string) $key;
            } elseif ($value !==false) {
                $htmlParts[] = "$key=\"$value\"";
            }
        }
        return implode(' ', $htmlParts);
    }

    /**
     * G??n??re un input de type checkbox
     * @param null|string $value
     * @param array $attributes
     * @return string
     */
    private function checkbox(?string $value, array $attributes)
    {
        $name = $attributes['name'];
        $html = "<input type=\"hidden\" name=\"$name\" value=\"0\">";
        if ($value) {
            $attributes['checked'] = true;
        }
        return $html . "<input type=\"checkbox\" " . $this->getHtmlFromArray($attributes) . " value=\"1\">";
    }
}
