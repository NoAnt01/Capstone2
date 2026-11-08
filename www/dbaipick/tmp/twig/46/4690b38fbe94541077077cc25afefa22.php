<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* server/collations/index.twig */
class __TwigTemplate_62a1064da0297ea64c6540ef5a520b7e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<div class=container-fluid>
  <h2>
    ";
        // line 3
        yield PhpMyAdmin\Html\Generator::getImage("s_asci");
        yield "
    ";
yield _gettext("Character sets and collations");
        // line 5
        yield "  </h2>

  ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["charsets"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["charset"]) {
            // line 8
            yield "    <div class=\"card mb-3\">
      <div class=\"card-header\">
        <div><strong>";
            // line 10
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["charset"], "name", [], "any", false, false, false, 10), "html", null, true);
            yield "</strong></div>
        <div>";
            // line 11
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["charset"], "description", [], "any", false, false, false, 11), "html", null, true);
            yield "</div>
      </div>
      <ul class=\"list-group list-group-flush\">
        ";
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["charset"], "collations", [], "any", false, false, false, 14));
            foreach ($context['_seq'] as $context["_key"] => $context["collation"]) {
                // line 15
                yield "          <li class=\"list-group-item\">
            <div class=\"row\">
              <div class=\"col\">
                <div><strong>";
                // line 18
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["collation"], "name", [], "any", false, false, false, 18), "html", null, true);
                yield "</strong></div>
                <div>";
                // line 19
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["collation"], "description", [], "any", false, false, false, 19), "html", null, true);
                yield "</div>
              </div>
              <div class=\"col align-self-center text-end\">
                ";
                // line 22
                if (CoreExtension::getAttribute($this->env, $this->source, $context["collation"], "is_default", [], "any", false, false, false, 22)) {
                    // line 23
                    yield "                  <span class=\"badge bg-secondary\">";
yield _pgettext("The collation is the default one", "default");
                    yield "</span>
                ";
                }
                // line 25
                yield "              </div>
            </div>
          </li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['collation'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            yield "      </ul>
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['charset'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        yield "</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "server/collations/index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  113 => 32,  105 => 29,  96 => 25,  90 => 23,  88 => 22,  82 => 19,  78 => 18,  73 => 15,  69 => 14,  63 => 11,  59 => 10,  55 => 8,  51 => 7,  47 => 5,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/collations/index.twig", "/codeunit/www/dbaipick/templates/server/collations/index.twig");
    }
}
