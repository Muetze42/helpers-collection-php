<?php

namespace NormanHuth\Helpers\Markdown;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ExpectedValues;

class Table
{
    /**
     * Table cell align left.
     */
    public const CELL_ALIGN_LEFT = STR_PAD_RIGHT;

    /**
     * Table cell align center.
     */
    public const CELL_ALIGN_CENTER = STR_PAD_BOTH;

    /**
     * Table cell align right.
     */
    public const CELL_ALIGN_RIGHT = STR_PAD_LEFT;

    /**
     * The default cell alignment.
     *
     * @var int
     */
    protected int $defaultAlign;

    /**
     * The Table cells items.
     *
     * @var array
     */
    protected array $cells = [];

    /**
     * The number of cells to be processed.
     *
     * @var int
     */
    protected int $cellCount;

    /**
     * The Table rows items.
     *
     * @var array
     */
    protected array $rows = [];

    /**
     * Array of the longest word in each row.
     *
     * @var array
     */
    protected array $lengths = [];

    /**
     * The rendered Markdown string.
     *
     * @var string
     */
    protected string $markdown = '';

    /**
     * The prefix punctuation for left align cell.
     *
     * @var string
     */
    protected string $alignLeftPrefix;

    /**
     * Create a new Table Instance.
     *
     * @param int    $defaultAlign
     * @param string $alignLeftPrefix
     */
    public function __construct(
        #[ExpectedValues(values: [self::CELL_ALIGN_LEFT, self::CELL_ALIGN_CENTER, self::CELL_ALIGN_RIGHT])]
        int $defaultAlign = self::CELL_ALIGN_LEFT,
        #[ExpectedValues(values: [':', '-'])]
        string $alignLeftPrefix = ':',
    ) {
        $this->defaultAlign = $defaultAlign;
        $this->alignLeftPrefix = $alignLeftPrefix;
    }

    /**
     * Add a Table cell.
     *
     * @param string   $title
     * @param int|null $align
     *
     * @return $this
     */
    public function addCell(
        string $title,
        #[ExpectedValues(values: [null, self::CELL_ALIGN_LEFT, self::CELL_ALIGN_CENTER, self::CELL_ALIGN_RIGHT])]
        int $align = null
    ): static {
        if (is_null($align)) {
            $align = $this->defaultAlign;
        }

        $this->cells[] = [
            'title' => $title,
            'algin' => $align,
        ];

        return $this;
    }

    /**
     * Alias for addCell method to simplify the transition from other packages.
     *
     * @param string   $title
     * @param int|null $align
     *
     * @return $this
     */
    public function addColumn(
        string $title,
        #[ExpectedValues(values: [null, self::CELL_ALIGN_LEFT, self::CELL_ALIGN_CENTER, self::CELL_ALIGN_RIGHT])]
        int $align = null
    ): static {
        return $this->addCell($title, $align);
    }

    /**
     * Add Table rows.
     *
     * @param array|Collection $rows
     *
     * @return $this
     */
    public function addRows(array|Collection $rows): static
    {
        if ($rows instanceof Collection) {
            $rows = $rows->toArray();
        }

        $this->rows = array_merge($this->rows, $rows);

        return $this;
    }

    /**
     * Add a table row.
     *
     * @param array $row
     *
     * @return $this
     */
    public function addRow(array $row): static
    {
        $this->rows[] = $row;

        return $this;
    }

    /**
     * Detect the longest string of each row.
     *
     * @return void
     */
    protected function setLengths(): void
    {
        $this->cellCount = count($this->cells);

        foreach ($this->cells as $key => $value) {
            $this->lengths[$key] = strlen($value['title']);
        }

        foreach ($this->rows as $row) {
            $row = array_values($row);
            foreach ($row as $key => $value) {
                $current = data_get($this->lengths, $key, 0);
                $length = strlen($value);
                if ($current && $length > data_get($this->lengths, $key)) {
                    $this->lengths[$key] = $length;
                }
            }
        }
    }

    /**
     * Create the Table heading and hyphens.
     *
     * @return void
     */
    protected function renderHeading(): void
    {
        foreach ($this->cells as $key => $cell) {
            $this->markdown .= '| ';

            $this->markdown .= str_pad(
                $cell['title'],
                $this->lengths[$key],
                ' ',
                $cell['algin']
            );
            $this->markdown .= ' ';
        }
        $this->markdown .= "|\n";

        foreach ($this->cells as $key => $cell) {
            $this->markdown .= '|';

            $hyphen = str_pad(
                '',
                $this->lengths[$key],
                '-',
                $cell['algin']
            );

            $hyphen = match ($cell['algin']) {
                self::CELL_ALIGN_LEFT => $this->alignLeftPrefix . '-' . $hyphen,
                self::CELL_ALIGN_RIGHT => $hyphen . '-:',
                default => ':' . $hyphen . ':',
            };

            $this->markdown .= $hyphen;
        }
        $this->markdown .= "|\n";
    }

    /**
     * Render the rows items.
     *
     * @return void
     */
    protected function renderRows(): void
    {
        foreach ($this->rows as $row) {
            $row = array_values($row);
            foreach ($row as $key => $value) {
                $this->markdown .= '| ';
                $this->markdown .= str_pad(
                    $value,
                    $this->lengths[$key],
                    ' ',
                    $this->cells[$key]['algin']
                );
                $this->markdown .= ' ';
            }
            $this->markdown .= "|\n";
        }
    }

    /**
     * Return rendered Markdown Table as string.
     *
     * @return string
     */
    public function render(): string
    {
        $this->setLengths();
        $this->renderHeading();
        $this->renderRows();

        return trim($this->markdown);
    }
}
