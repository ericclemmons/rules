<?php

namespace CodeMeme\RulesBundle;

use Doctrine\Common\Collections\ArrayCollection;

class RulesEngine
{

    private $aliases;

    private $rules;

    private $targets;

    public function __construct($rules = array())
    {
        $this->aliases  = new ArrayCollection;
        $this->rules    = new ArrayCollection;
        $this->targets  = new ArrayCollection;
    }

    public function setAlias($alias, $value)
    {
        $this->getAliases()->set($alias, $value);
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
        
        return $this;
    }

    public function addRule($rule)
    {
        // Import existing aliases into the new rule
        foreach ($this->getAliases() as $alias => $value) {
            if (! $rule->getAliases()->containsKey($alias)) {
                $rule->getAliases()->set($alias, $value);
            }
        }
        
        $this->getRules()->add($rule);
    }

    public function addRules($rules)
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
        
        return $this;
    }

    public function addTarget($target)
    {
        $this->getTargets()->add($target);
    }

    public function addTargets($targets)
    {
        foreach ($targets as $target) {
            $this->addTarget($target);
        }
    }

    public function getTargets()
    {
        return $this->targets;
    }

    public function setTargets($targets)
    {
        $this->targets = $targets;
        
        return $this;
    }

    public function evaluate($targets = array())
    {
        foreach ($this->getTargets() as $target) {
            $targets[] = $target;
        }
        
        foreach ($this->getRules() as $rule) {
            $rule->evaluate($targets);
        }
    }

}