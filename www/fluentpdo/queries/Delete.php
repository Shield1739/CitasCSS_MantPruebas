<?php

namespace Shield1739\UTP\CitasCss\fluentpdo\queries;

use Shield1739\UTP\CitasCss\fluentpdo\
{FluentPdoException, Query};

/**
 * DELETE query builder
 *
 * @method Delete  leftJoin(string $statement) add LEFT JOIN to query
 *                        ($statement can be 'table' name only or 'table:' means back reference)
 * @method Delete  innerJoin(string $statement) add INNER JOIN to query
 *                        ($statement can be 'table' name only or 'table:' means back reference)
 * @method Delete  from(string $table) add LIMIT to query
 * @method Delete  orderBy(string $column) add ORDER BY to query
 * @method Delete  limit(int $limit) add LIMIT to query
 */
class Delete extends Common
{

    private bool $ignore;

    /**
     * Delete constructor
     *
     * @param Query $fluent
     * @param string $table
     */
    public function __construct(Query $fluent, string $table)
    {
        $this->ignore = false;
        $clauses = [
            'DELETE FROM' => [$this, 'getClauseDeleteFrom'],
            'DELETE' => [$this, 'getClauseDelete'],
            'FROM' => null,
            'JOIN' => [$this, 'getClauseJoin'],
            'WHERE' => [$this, 'getClauseWhere'],
            'ORDER BY' => ', ',
            'LIMIT' => null,
        ];

        parent::__construct($fluent, $clauses);

        $this->statements['DELETE FROM'] = $table;
        $this->statements['DELETE'] = $table;
    }

    /**
     * Forces delete operation to fail silently
     *
     * @return Delete
     */
    public function ignore(): static
    {
        $this->ignore = true;

        return $this;
    }

    /**
     * @return string
     * @throws FluentPdoException
     *
     */
    protected function buildQuery(): string
    {
        if ($this->statements['FROM'])
        {
            unset($this->clauses['DELETE FROM']);
        }
        else
        {
            unset($this->clauses['DELETE']);
        }

        return parent::buildQuery();
    }

    /**
     * Execute DELETE query
     *
     * @return bool
     * @throws FluentPdoException
     *
     */
    public function execute(): bool
    {
        if (empty($this->statements['WHERE']))
        {
            throw new FluentPdoException('Delete queries must contain a WHERE clause to prevent unwanted data loss');
        }

        $result = parent::execute();
        if ($result)
        {
            return $result->rowCount();
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getClauseDelete(): string
    {
        return 'DELETE' . ($this->ignore ? " IGNORE" : '') . ' ' . $this->statements['DELETE'];
    }

    /**
     * @return string
     */
    protected function getClauseDeleteFrom(): string
    {
        return 'DELETE' . ($this->ignore ? " IGNORE" : '') . ' FROM ' . $this->statements['DELETE FROM'];
    }

}
