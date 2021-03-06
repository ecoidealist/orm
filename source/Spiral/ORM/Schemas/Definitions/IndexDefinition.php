<?php
/**
 * Spiral, Core Components
 *
 * @author Wolfy-J
 */

namespace Spiral\ORM\Schemas\Definitions;

/**
 * Index definition options.
 */
final class IndexDefinition
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var array
     */
    private $index;

    /**
     * @var bool
     */
    private $unique;

    /**
     * @param array       $columns
     * @param bool        $unique
     * @param string|null $name
     */
    public function __construct(array $columns, bool $unique = false, string $name = null)
    {
        $this->index = $columns;
        $this->unique = $unique;

        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->index;
    }

    /**
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * Generate unique index name.
     *
     * @return string
     */
    public function getName(): string
    {
        if (!empty($this->name)) {
            return $this->name;
        }

        $name = ($this->isUnique() ? 'unique_' : 'index_') . join('_', $this->getColumns());

        return strlen($name) > 64 ? md5($name) : $name;
    }

    /**
     * So we can compare indexes.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode([$this->index, $this->unique]);
    }
}