<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @help_topics/action.creating.html.twig */
class __TwigTemplate_e85583c4bdc0711cd48ef32e635f0481 extends \Twig\Template
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
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        ob_start(function () { return ''; });
        // line 8
        echo "  ";
        echo t("Actions", array());
        $context["actions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 10
        $context["actions"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["actions_link_text"] ?? null), 10, $this->source), "entity.action.collection"));
        // line 11
        ob_start(function () { return ''; });
        // line 12
        echo "  ";
        echo t("Administer actions", array());
        $context["action_permissions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 14
        $context["action_permissions"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["action_permissions_link_text"] ?? null), 14, $this->source), "user.admin_permissions.module", ["modules" => "action"]));
        // line 15
        $context["action_overview"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getTopicLink("action.overview"));
        // line 16
        echo "<h2>";
        echo t("Goal", array());
        echo "</h2>
<p>";
        // line 17
        echo t("Create an advanced action. You can, for example, create an action to change the author of multiple content items. See @action_overview for more about actions.", array("@action_overview" => ($context["action_overview"] ?? null), ));
        echo "</p>
<h2>";
        // line 18
        echo t("Who can create actions?", array());
        echo "</h2>
<p>";
        // line 19
        echo t("Users with the <em>@action_permissions</em> permission (typically administrators) can create actions.", array("@action_permissions" => ($context["action_permissions"] ?? null), ));
        echo "</p>
<h2>";
        // line 20
        echo t("Steps", array());
        echo "</h2>
<ol>
  <li>";
        // line 22
        echo t("In the <em>Manage</em> administrative menu, navigate to <em>Configuration</em> &gt; <em>System</em> &gt; <em>@actions</em>. A list of all actions is shown.", array("@actions" => ($context["actions"] ?? null), ));
        echo "</li>
  <li>";
        // line 23
        echo t("Choose an advanced action from the dropdown and click <em>Create</em>.", array());
        echo "</li>
  <li>";
        // line 24
        echo t("Enter a name for the action in the <em>Label</em> field. This label will be visible for the user.", array());
        echo "</li>
  <li>";
        // line 25
        echo t("Configure any of the other available options. These will depend on the kind of action that you have chosen.", array());
        echo "</li>
  <li>";
        // line 26
        echo t("Click <em>Save</em>. You will be returned to the list of actions, with your new action added to the list.", array());
        echo "</li>
  <li>";
        // line 27
        echo t("To edit an action you have previously created, click <em>Configure</em> in the <em>Operations</em> drop-down list. To delete an action you have previously created, click <em>Delete</em> in the <em>Operations</em> drop-down list.", array());
        echo "</li>
</ol>";
    }

    public function getTemplateName()
    {
        return "@help_topics/action.creating.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 27,  95 => 26,  91 => 25,  87 => 24,  83 => 23,  79 => 22,  74 => 20,  70 => 19,  66 => 18,  62 => 17,  57 => 16,  55 => 15,  53 => 14,  49 => 12,  47 => 11,  45 => 10,  41 => 8,  39 => 7,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/action.creating.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\TheamDebug\\web\\core\\modules\\help_topics\\help_topics\\action.creating.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 7, "trans" => 8);
        static $filters = array("escape" => 17);
        static $functions = array("render_var" => 10, "help_route_link" => 10, "help_topic_link" => 15);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'help_route_link', 'help_topic_link']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
